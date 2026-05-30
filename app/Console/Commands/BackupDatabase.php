<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Ifsnop\Mysqldump\Mysqldump;

class BackupDatabase extends Command
{
    protected $signature   = 'db:backup';
    protected $description = 'Sauvegarde la base de données (pure PHP, sans exec) — 7 jours de rétention';

    public function handle(): int
    {
        $host     = config('database.connections.mysql.host');
        $port     = config('database.connections.mysql.port', 3306);
        $database = config('database.connections.mysql.database');
        $username = config('database.connections.mysql.username');
        $password = config('database.connections.mysql.password');

        $backupDir = storage_path('app/backups');
        if (!is_dir($backupDir)) {
            mkdir($backupDir, 0755, true);
        }

        $filename  = 'backup_' . now()->format('Y-m-d_H-i-s') . '.sql';
        $localPath = $backupDir . '/' . $filename;

        try {
            $dump = new Mysqldump(
                "mysql:host={$host};port={$port};dbname={$database}",
                $username,
                $password,
                [
                    'compress'        => Mysqldump::GZIP,
                    'single-transaction' => true,
                    'add-drop-table'  => true,
                ]
            );
            $dump->start($localPath . '.gz');
        } catch (\Exception $e) {
            $this->error('Backup échoué : ' . $e->getMessage());
            Log::error('db:backup failed', ['error' => $e->getMessage()]);
            return self::FAILURE;
        }

        $finalPath = $localPath . '.gz';
        $sizeMb    = file_exists($finalPath) ? round(filesize($finalPath) / 1024 / 1024, 2) : 0;
        $this->info("Backup créé : {$filename}.gz ({$sizeMb} MB)");

        // Supprimer les backups de plus de 7 jours
        $deleted = 0;
        foreach (glob($backupDir . '/backup_*.sql.gz') as $file) {
            if (filemtime($file) < now()->subDays(7)->timestamp) {
                unlink($file);
                $deleted++;
            }
        }

        if ($deleted > 0) {
            $this->info("{$deleted} ancien(s) backup(s) supprimé(s).");
        }

        return self::SUCCESS;
    }
}
