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
    protected $commands = [
        Commands\DeleteVideo::class,
    ];
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('delete:video')->twiceMonthly();
        // $schedule->command('inspire')->hourly();
        // $schedule->command('queue:work --stop-when-empty')
        // ->everyMinute()
        // ->withoutOverlapping();
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
