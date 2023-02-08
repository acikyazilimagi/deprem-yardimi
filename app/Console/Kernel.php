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
        // 10 dakika bir çalışacak şekilde ayarlandı.
        // Komutun üst üste binmemesi için 15 dakika overlapping eklendi.
        // duplicate dataları temizleme işlemi.
        $schedule->command('duplicate-data-checker')
            ->everyTenMinutes()
            ->runInBackground()
            ->withoutOverlapping(15);
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
