<?php

namespace App\Console;

use App\Console\Commands\DeleteItemsData;
use App\Console\Commands\InsertNewItems;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
        'App\Console\Commands\InsertNewItems',
        'App\Console\Commands\DeleteItemsData'
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')
        //          ->hourly();

        $schedule->command('command:deleteItem')->dailyAt('22:00');
        $schedule->command('command:insert')->everyFiveMinutes()->between('22:05', '1:30');
        $schedule->command('command:insert')->cron('* * * * *')->between('1:30', '22:00');

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
