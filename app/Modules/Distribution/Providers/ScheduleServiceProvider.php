<?php

namespace App\Modules\Distribution\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Console\Scheduling\Schedule;
use App\Modules\Distribution\Jobs\DailyScheduleTaskDistribution;

class ScheduleServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->booted(function () {
            $schedule = $this->app->make(Schedule::class);

            // $schedule->command('inspire')->hourly();
            $schedule->job(new DailyScheduleTaskDistribution())->dailyAt(config('distribution.distribution_hour_every_day'));
        });
    }
}
