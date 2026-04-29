<?php
/**
 * Migration Afrique -> Europe V2
 * Dynamically check existence in DB and insert.
 */

$afriqueSql = __DIR__ . '/../u245636672_CompteAfrique.sql';
$db = new mysqli('127.0.0.1', 'root', '', 'compteeurope');

if ($db->connect_error) {
    die("Connection failed: " . $db->connect_error);
}

// ─── Columns ─────────────────────────────────────────────────────────────────
$cols = [
    'users'                => ['id','nom','prenom','email','phone','email_verified_at','password','credit_user','code_parrainage','parrain_id','remember_token','created_at','updated_at'],
    'comptes'              => ['id','user_id','nom','prenom','email','phone_number','country','address','devise','lang','account_balance','account_balance2','credits_available','account_type','code_virement','account_status','password','transfer_supported','token','iban','parameters','card_number','numerocompte','cvv','start_percentage','end_percentage','failure_message','photo_path','alert_email','alert_sms','is_default','created_at','updated_at','auto_deletes_at','is_auto_created'],
    'affiliations'         => ['id','user_id','parrain_id','code_affiliation','commission_rate','total_commissions','total_parraines','is_active','settings','created_at','updated_at'],
    'transfers'            => ['id','compte_id','compte_id_inferred','user_id','numerocompte','name_servieur','beneficiary_name','reason','devise','token','solidvire','status','created_at','updated_at'],
    'commissions'          => ['id','affiliation_id','parraine_user_id','compte_id','action_type','montant_base','taux_commission','montant_commission','statut','date_action','date_validation','details','created_at','updated_at'],
    'recharge_transactions'=> ['id','user_id','compte_id','transaction_id','amount','credits_earned','payment_method','payment_provider','status','external_transaction_id','payment_details','response_data','failure_reason','completed_at','created_at','updated_at'],
    'remboursements'       => ['id','compte_id','montant','created_at','updated_at'],
    'transaction_histories'=> ['id','user_id','compte_id','transfer_id','mobile_number','transaction_type','amount','description','devise','created_at','updated_at'],
    'unlock_codes'         => ['id','compte_id','transfer_id','code','expires_at','used_at','created_at','updated_at'],
    'support_tickets'      => ['id','user_id','subject','status','last_message_at','created_at','updated_at'],
    'support_messages'     => ['id','support_ticket_id','user_id','sent_by_admin','content','file_name','file_path','file_type','file_size','voice_path','read_at','created_at','updated_at'],
];

// ─── Helpers ─────────────────────────────────────────────────────────────────
function extractRows(string $sql, string $table): array {
    $rows = [];
    preg_match_all('/INSERT INTO `' . preg_quote($table, '/') . '`[^;]+VALUES\s*([\s\S]+?);/i', $sql, $m);
    foreach ($m[1] as $block) {
        preg_match_all('/\(([^()]*(?:\([^()]*\)[^()]*)*)\)/s', $block, $t);
        foreach ($t[1] as $inner) {
            $rows[] = parseTuple($inner);
        }
    }
    return $rows;
}

function parseTuple(string $inner): array {
    $vals = []; $cur = ''; $inStr = false; $esc = false; $q = '';
    for ($i = 0, $len = strlen($inner); $i < $len; $i++) {
        $c = $inner[$i];
        if ($esc) { $cur .= $c; $esc = false; continue; }
        if ($c === '\\' && $inStr) { $cur .= $c; $esc = true; continue; }
        if (!$inStr && ($c === "'" || $c === '"')) { $inStr = true; $q = $c; $cur .= $c; continue; }
        if ($inStr && $c === $q) { $inStr = false; $cur .= $c; continue; }
        if (!$inStr && $c === ',') { $vals[] = convertVal(trim($cur)); $cur = ''; continue; }
        $cur .= $c;
    }
    if ($cur !== '') $vals[] = convertVal(trim($cur));
    return $vals;
}

function convertVal(string $v) {
    if (strtoupper($v) === 'NULL') return null;
    if (preg_match("/^'(.*)'$/s", $v, $m)) return stripslashes($m[1]);
    if (is_numeric($v)) return $v + 0;
    return $v;
}

function toAssoc(array $row, array $c): array {
    $r = [];
    foreach ($c as $i => $col) $r[$col] = $row[$i] ?? null;
    return $r;
}

function sqlVal($v): string {
    if ($v === null) return 'NULL';
    if (is_numeric($v) && !preg_match('/^0\d/', (string)$v)) return (string)$v;
    return "'" . addslashes((string)$v) . "'";
}

// ─── Extraction ───────────────────────────────────────────────────────────────
echo "Lecture du dump Afrique...\n";
$sql = file_get_contents($afriqueSql);
$afrique = [];
foreach (array_keys($cols) as $t) {
    $afrique[$t] = extractRows($sql, $t);
    echo "  Table $t : " . count($afrique[$t]) . " records found.\n";
}

// ─── Mappings ─────────────────────────────────────────────────────────────────
$userMap = []; $compteMap = []; $affiliationMap = [];
$transferMap = []; $ticketMap = [];

$nextIds = [];
foreach ($cols as $t => $c) {
    $res = $db->query("SELECT MAX(id) FROM `$t` WHERE id < 100000");
    $row = $res->fetch_row();
    $nextIds[$t] = max((int)($row[0] ?? 0) + 1, 100000);
}

$db->query("SET FOREIGN_KEY_CHECKS=0");

// 1. USERS
echo "Processing USERS...\n";
foreach ($afrique['users'] as $r) {
    $u = toAssoc($r, $cols['users']);
    $email = $db->real_escape_string(strtolower($u['email']));
    $res = $db->query("SELECT id FROM users WHERE LOWER(email) = '$email'");
    if ($res && $res->num_rows > 0) {
        $row = $res->fetch_assoc();
        $userMap[(int)$u['id']] = (int)$row['id'];
        echo "  - User exists: {$u['email']} (ID {$row['id']})\n";
    } else {
        $newId = $nextIds['users']++;
        $userMap[(int)$u['id']] = $newId;
        $u['id'] = $newId;
        $u['parrain_id'] = null; // Update later
        $u['region'] = 'afrique';
        $sql = "INSERT INTO users (" . implode(',', array_keys($u)) . ") VALUES (";
        $vals = array_map('sqlVal', $u);
        $sql .= implode(',', $vals) . ")";
        if ($db->query($sql)) {
            echo "  + User created: {$u['email']} (ID $newId)\n";
        } else {
            echo "  ! Error creating user {$u['email']}: " . $db->error . "\n";
        }
    }
}

// Update parrain_id
foreach ($afrique['users'] as $r) {
    $u = toAssoc($r, $cols['users']);
    if ($u['parrain_id'] && isset($userMap[(int)$u['parrain_id']])) {
        $newPid = $userMap[(int)$u['parrain_id']];
        $newUid = $userMap[(int)$u['id']];
        $db->query("UPDATE users SET parrain_id = $newPid WHERE id = $newUid");
    }
}

// 2. COMPTES
echo "Processing COMPTES...\n";
foreach ($afrique['comptes'] as $r) {
    $c = toAssoc($r, $cols['comptes']);
    if (!isset($userMap[(int)$c['user_id']])) continue;
    
    $num = $db->real_escape_string($c['numerocompte']);
    $res = $db->query("SELECT id FROM comptes WHERE numerocompte = '$num'");
    if ($res && $res->num_rows > 0) {
        $row = $res->fetch_assoc();
        $compteMap[(int)$c['id']] = (int)$row['id'];
        echo "  - Compte exists: $num (ID {$row['id']})\n";
    } else {
        $newId = $nextIds['comptes']++;
        $compteMap[(int)$c['id']] = $newId;
        $c['id'] = $newId;
        $c['user_id'] = $userMap[(int)$c['user_id']];
        $c['region'] = 'afrique';
        $sql = "INSERT INTO comptes (" . implode(',', array_keys($c)) . ") VALUES (" . implode(',', array_map('sqlVal', $c)) . ")";
        if ($db->query($sql)) {
            echo "  + Compte created: $num (ID $newId)\n";
        } else {
            echo "  ! Error creating compte $num: " . $db->error . "\n";
        }
    }
}

// 3. AFFILIATIONS
echo "Processing AFFILIATIONS...\n";
foreach ($afrique['affiliations'] as $r) {
    $a = toAssoc($r, $cols['affiliations']);
    if (!isset($userMap[(int)$a['user_id']])) continue;
    
    $uid = $userMap[(int)$a['user_id']];
    $res = $db->query("SELECT id FROM affiliations WHERE user_id = $uid");
    if ($res && $res->num_rows > 0) {
        $row = $res->fetch_assoc();
        $affiliationMap[(int)$a['id']] = (int)$row['id'];
    } else {
        $newId = $nextIds['affiliations']++;
        $affiliationMap[(int)$a['id']] = $newId;
        $a['id'] = $newId;
        $a['user_id'] = $uid;
        $a['parrain_id'] = ($a['parrain_id'] && isset($userMap[(int)$a['parrain_id']])) ? $userMap[(int)$a['parrain_id']] : null;
        $a['code_affiliation'] .= '_AF';
        $sql = "INSERT INTO affiliations (" . implode(',', array_keys($a)) . ") VALUES (" . implode(',', array_map('sqlVal', $a)) . ")";
        $db->query($sql);
    }
}

// 4. TRANSFERS
echo "Processing TRANSFERS...\n";
foreach ($afrique['transfers'] as $r) {
    $t = toAssoc($r, $cols['transfers']);
    if (!isset($userMap[(int)$t['user_id']])) continue;
    
    $newId = $nextIds['transfers']++;
    $transferMap[(int)$t['id']] = $newId;
    $t['id'] = $newId;
    $t['user_id'] = $userMap[(int)$t['user_id']];
    $t['compte_id'] = ($t['compte_id'] && isset($compteMap[(int)$t['compte_id']])) ? $compteMap[(int)$t['compte_id']] : null;
    $sql = "INSERT INTO transfers (" . implode(',', array_keys($t)) . ") VALUES (" . implode(',', array_map('sqlVal', $t)) . ")";
    $db->query($sql);
}

// 5. COMMISSIONS
echo "Processing COMMISSIONS...\n";
foreach ($afrique['commissions'] as $r) {
    $c = toAssoc($r, $cols['commissions']);
    if (!isset($affiliationMap[(int)$c['affiliation_id']])) continue;
    
    $c['id'] = $nextIds['commissions']++;
    $c['affiliation_id'] = $affiliationMap[(int)$c['affiliation_id']];
    $c['parraine_user_id'] = ($c['parraine_user_id'] && isset($userMap[(int)$c['parraine_user_id']])) ? $userMap[(int)$c['parraine_user_id']] : null;
    $c['compte_id'] = ($c['compte_id'] && isset($compteMap[(int)$c['compte_id']])) ? $compteMap[(int)$c['compte_id']] : null;
    $sql = "INSERT INTO commissions (" . implode(',', array_keys($c)) . ") VALUES (" . implode(',', array_map('sqlVal', $c)) . ")";
    $db->query($sql);
}

// 6. RECHARGE_TRANSACTIONS
echo "Processing RECHARGE_TRANSACTIONS...\n";
foreach ($afrique['recharge_transactions'] as $r) {
    $rt = toAssoc($r, $cols['recharge_transactions']);
    if (!isset($userMap[(int)$rt['user_id']])) continue;
    
    $rt['id'] = $nextIds['recharge_transactions']++;
    $rt['user_id'] = $userMap[(int)$rt['user_id']];
    $rt['compte_id'] = ($rt['compte_id'] && isset($compteMap[(int)$rt['compte_id']])) ? $compteMap[(int)$rt['compte_id']] : null;
    $rt['transaction_id'] .= '_AF';
    $sql = "INSERT INTO recharge_transactions (" . implode(',', array_keys($rt)) . ") VALUES (" . implode(',', array_map('sqlVal', $rt)) . ")";
    $db->query($sql);
}

// 7. REMBOURSEMENTS
echo "Processing REMBOURSEMENTS...\n";
foreach ($afrique['remboursements'] as $r) {
    $rb = toAssoc($r, $cols['remboursements']);
    if (!isset($compteMap[(int)$rb['compte_id']])) continue;
    $rb['id'] = $nextIds['remboursements']++;
    $rb['compte_id'] = $compteMap[(int)$rb['compte_id']];
    $sql = "INSERT INTO remboursements (" . implode(',', array_keys($rb)) . ") VALUES (" . implode(',', array_map('sqlVal', $rb)) . ")";
    $db->query($sql);
}

// 8. TRANSACTION_HISTORIES
echo "Processing TRANSACTION_HISTORIES...\n";
foreach ($afrique['transaction_histories'] as $r) {
    $th = toAssoc($r, $cols['transaction_histories']);
    if (!isset($userMap[(int)$th['user_id']]) || !isset($compteMap[(int)$th['compte_id']])) continue;
    $th['id'] = $nextIds['transaction_histories']++;
    $th['user_id'] = $userMap[(int)$th['user_id']];
    $th['compte_id'] = $compteMap[(int)$th['compte_id']];
    $th['transfer_id'] = ($th['transfer_id'] && isset($transferMap[(int)$th['transfer_id']])) ? $transferMap[(int)$th['transfer_id']] : null;
    $sql = "INSERT INTO transaction_histories (" . implode(',', array_keys($th)) . ") VALUES (" . implode(',', array_map('sqlVal', $th)) . ")";
    $db->query($sql);
}

// 9. UNLOCK_CODES
echo "Processing UNLOCK_CODES...\n";
foreach ($afrique['unlock_codes'] as $r) {
    $uc = toAssoc($r, $cols['unlock_codes']);
    if ($uc['compte_id'] && !isset($compteMap[(int)$uc['compte_id']])) continue;
    $uc['id'] = $nextIds['unlock_codes']++;
    $uc['compte_id'] = $uc['compte_id'] ? $compteMap[(int)$uc['compte_id']] : null;
    $uc['transfer_id'] = ($uc['transfer_id'] && isset($transferMap[(int)$uc['transfer_id']])) ? $transferMap[(int)$uc['transfer_id']] : null;
    $sql = "INSERT INTO unlock_codes (" . implode(',', array_keys($uc)) . ") VALUES (" . implode(',', array_map('sqlVal', $uc)) . ")";
    $db->query($sql);
}

// 10. SUPPORT_TICKETS
echo "Processing SUPPORT_TICKETS...\n";
foreach ($afrique['support_tickets'] as $r) {
    $st = toAssoc($r, $cols['support_tickets']);
    if (!isset($userMap[(int)$st['user_id']])) continue;
    $oldId = (int)$st['id'];
    $newId = $nextIds['support_tickets']++;
    $ticketMap[$oldId] = $newId;
    $st['id'] = $newId;
    $st['user_id'] = $userMap[(int)$st['user_id']];
    $sql = "INSERT INTO support_tickets (" . implode(',', array_keys($st)) . ") VALUES (" . implode(',', array_map('sqlVal', $st)) . ")";
    $db->query($sql);
}

// 11. SUPPORT_MESSAGES
echo "Processing SUPPORT_MESSAGES...\n";
foreach ($afrique['support_messages'] as $r) {
    $sm = toAssoc($r, $cols['support_messages']);
    if (!isset($ticketMap[(int)$sm['support_ticket_id']])) continue;
    $sm['id'] = $nextIds['support_messages']++;
    $sm['support_ticket_id'] = $ticketMap[(int)$sm['support_ticket_id']];
    $sm['user_id'] = ($sm['user_id'] && isset($userMap[(int)$sm['user_id']])) ? $userMap[(int)$sm['user_id']] : null;
    $sql = "INSERT INTO support_messages (" . implode(',', array_keys($sm)) . ") VALUES (" . implode(',', array_map('sqlVal', $sm)) . ")";
    $db->query($sql);
}

$db->query("SET FOREIGN_KEY_CHECKS=1");
echo "\nMigration terminée !\n";
