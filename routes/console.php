<?php

use App\Console\Commands\SendRenewalReminders;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

// Send renewal reminder emails every day at 8:00 AM
Schedule::command(SendRenewalReminders::class)->dailyAt('08:00');
