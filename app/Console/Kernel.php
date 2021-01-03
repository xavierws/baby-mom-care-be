<?php

namespace App\Console;

use App\Models\Advice;
use App\Models\NotificationLog;
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
        // $schedule->command('inspire')->hourly();
        $schedule->call(function () {
            $now = now();
            $dayOfYear = $now->dayOfYear;

            foreach (Advice::all() as $advice) {
                $freq = $advice->frequency;

                if ($dayOfYear % $freq == 0) {
                    NotificationLog::create([
                        'advice' => $advice->id,
                    ]);
                }
            }
        })->daily();

        $schedule->call(function () {

        })->daily();
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
