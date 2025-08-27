<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

$commands = config('schedule.commands', []);

foreach ($commands as $cmd) {
    Schedule::command($cmd['command'])
        ->cron($cmd['schedule'])
        ->description($cmd['description'] ?? '');
}