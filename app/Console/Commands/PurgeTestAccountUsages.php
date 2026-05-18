<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class PurgeTestAccountUsages extends Command
{
    protected $signature = 'usages:purge-test-accounts';
    protected $description = 'Supprime les enregistrements contrat-don et contrat-prêt des comptes de test';

    private const EXCLUDED_EMAILS = [
        'candide730@gmail.com',
        'lalyaisidore@gmail.com',
        'floralalya@gmail.com',
        'isidore@lannkin.com',
        'isiserviceplus@gmail.com',
    ];

    public function handle()
    {
        $userIds = DB::table('users')
            ->whereIn('email', self::EXCLUDED_EMAILS)
            ->pluck('id');

        if ($userIds->isEmpty()) {
            $this->info('Aucun compte de test trouvé.');
            return;
        }

        $don  = DB::table('contrat_don_usages')->whereIn('user_id', $userIds)->delete();
        $pret = DB::table('contrat_pret_usages')->whereIn('user_id', $userIds)->delete();

        $this->info("Supprimé : {$don} entrée(s) contrat-don, {$pret} entrée(s) contrat-prêt.");
    }
}
