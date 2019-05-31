<?php

namespace App\Console;

use App\Alert;
use App\Console\Commands\FetchTickers;
use App\Jobs\ProcessAlert;
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
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('tickers:clear')->monthly();
        $schedule->job(FetchTickers::class)->everyFiveMinutes();
        $schedule->call(function(){
            Alert::enabled()->get()->each([ProcessAlert::class, 'dispatch']);
        })->everyFiveMinutes();
        $schedule->command('coinpayment:transaction-check')
            ->everyMinute();
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
