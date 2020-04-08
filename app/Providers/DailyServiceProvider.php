<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Library\Services\DailyReport;
use App\Library\Services\ReportClient;

class DailyServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(ReportClient::class, function () {
            return new ReportClient();
        });

        $this->app->bind(DailyReport::class, function () {
            return new DailyReport();
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
    }
}
