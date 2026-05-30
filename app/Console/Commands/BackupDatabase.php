<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class BackupDatabase extends Command
{
    protected $signature   = 'db:backup';
    protected $description = 'Sauvegarde la base de données MySQL (mysqldump) et supprime les backups de plus de 7 jours';

    public function handle(): int
    {
        $host     = config('database.connections.mysql.host');
        $port     = config('database.connections.mysql.port', 3306);
        $database = config('database.connections.mysql.database');
        $username = config('database.connections.mysql.username');
        $password = config('database.connections.mysql.password');

        $filename  = 'backup_' . now()->format('Y-m-d_H-i-s') . '.sql.gz';
        $localPath = storage_path('app/backups/' . $filename);

        if (!is_dir(storage_path('app/backups'))) {
            mkdir(storage_path('app/backups'), 0755, true);
        }

        $command = sprintf(
            'mysqldump --host=%s --port=%s --user=%s --password=%s --single-transaction --routines --triggers %s | gzip > %s 2>&1',
            escapeshellarg($host),
            escapeshellarg($port),
            escapeshellarg($username),
            escapeshellarg($password),
            escapeshellarg($database),
            escapeshellarg($localPath)
        );

        exec($command, $output, $exitCode);

        if ($exitCode !== 0 || !file_exists($localPath) || filesize($localPath) < 100) {
            $this->error("Backup échoué (code {$exitCode}).");
            \Illuminate\Support\Facades\Log::error("db:backup failed", ['exit' => $exitCode, 'output' => $output]);
            return self::FAILURE;
        }

        $sizeMb = round(filesize($localPath) / 1024 / 1024, 2);
        $this->info("Backup créé : {$filename} ({$sizeMb} MB)");

        // Supprimer les backups de plus de 7 jours
        $deleted = 0;
        foreach (glob(storage_path('app/backups/backup_*.sql.gz')) as $file) {
            if (filemtime($file) < now()->subDays(7)->timestamp) {
                unlink($file);
                $deleted++;
            }
        }

        if ($deleted > 0) {
            $this->info("Anciens backups supprimés : {$deleted}");
        }

        return self::SUCCESS;
    }
}
