<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('sms:overdue-reminders')->weekdays()->dailyAt('08:05');
        $schedule->command('sync:survey-data')->weekdays()->dailyAt('08:05');
        $schedule->command('sync:online-loans')->dailyAt('08:05');
        $schedule->command('sms:customers-reminder')->weekdays()->dailyAt('18:05');
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
