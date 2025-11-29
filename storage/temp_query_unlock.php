<?php
try {
    $db = new PDO('mysql:host=127.0.0.1;dbname=compteeurope;port=3306;charset=utf8mb4','root','');
    $stmt = $db->query('SELECT id, code, compte_id, transfer_id, used_at, created_at FROM unlock_codes ORDER BY id DESC LIMIT 50');
    if (!$stmt) {
        echo "Query failed\n";
        exit(1);
    }
    foreach ($stmt as $row) {
        echo implode("\t", [
            $row['id'] ?? 'NULL',
            $row['code'] ?? 'NULL',
            $row['compte_id'] ?? 'NULL',
            $row['transfer_id'] ?? 'NULL',
            $row['used_at'] ?? 'NULL',
            $row['created_at'] ?? 'NULL'
        ]) . "\n";
    }
} catch (Exception $e) {
    echo 'Error: ' . $e->getMessage() . "\n";
    exit(1);
}
