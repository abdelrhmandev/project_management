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

        $schedule->command('command:clearappcaching')->weekly();

        $schedule->command('command:contractshandler')->everyMinute();

        $schedule->command('command:emailsent')->everyMinute();

        $schedule->command('command:projectemail')->dailyAt('9:00');
        $schedule->command('warning:email')->dailyAt('9:00');
        $schedule->call(function() {
            \App\Http\Controllers\Backoffice\ProjectController::_sendProjectWarningExEmail();
        })->dailyAt('9:00');
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');
        require base_path('routes/console.php');
    }
}
