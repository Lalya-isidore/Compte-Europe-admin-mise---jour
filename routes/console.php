<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

// Purge des contrats expirés — chaque nuit à 3h00
Schedule::command('contracts:purge-expired')->dailyAt('03:00');

// Backup base de données — chaque nuit à 02h00
Schedule::command('db:backup')->dailyAt('02:00');
