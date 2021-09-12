<?php

namespace App\Console;

use App\Actions\PushNotification;
use App\Models\Advice;
use App\Models\NotificationLog;
use App\Models\User;
use Carbon\Carbon;
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
                        'notification' => $advice->name,
                        'nurse_id' => null,
                        'type' => 'advice',
                    ]);
                }
            }
        })->everyMinute();

        $schedule->call(function () {

            $users = User::with('userable')->where('role_id', 10)->get();
            $now = now();

            foreach ($users as $user) {
                $date = Carbon::parse($user->userable->marked_date);

                if ($now->diffInDays($date) == 7 && $user->fcm_token) {
                    $title = 'reminder kontrol';
                    $des = 'jangan lupa untuk mengisi kontrol';
                    PushNotification::handle($user->fcm_token, $title, $des);

                    $user->userable->marked_date = $now;
                    $user->userable->save();
                }

                $resume_date = Carbon::parse($user->userable->resume_pulang->date);
                if ($now->diffInDays($resume_date) == 0 && $user->fcm_token) {
                    $title = 'reminder kontrol';
                    $des = 'jangan lupa untuk mengisi kontrol';
                    PushNotification::handle($user->fcm_token, $title, $des);
                }

                $tanggal_dibuat = Carbon::parse($user->userable->resume_pulang->created_at);
                if ($now->diffInDays($tanggal_dibuat) == 28) {
                    NotificationLog::create([
                        'notification' => "jangan lupa isi survey ketiga",
                        'nurse_id' => $user->userable->id,
                        'type' => 'survey',
                    ]);
                }

            }
        })->everyMinute();

        $schedule->call(function () {
            $users = User::where('role_id', 10)->get();

            foreach ($users as $user) {
                $kontrol = $user->userable->kontrols->orderBy('order', 'desc')->limit(1)->get();

                foreach ($kontrol->advices as $advice) {
                    $title = $advice->name;
                    $des = $advice->description;
                    PushNotification::handle($user->fcm_token, $title, $des);
                }
            }
        })->everyMinute();
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
