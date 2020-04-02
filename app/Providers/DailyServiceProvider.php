<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Library\Services\DailyReport;
use GuzzleHttp\Client;

class DailyServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(Client::class, function () {
            return new Client([
                'headers' => [
                    'Accept' => 'text/csv',
                ],
                'stream' => true,
                'timeout' => env('DAILY_REPORT_TIMEOUT'),
                'base_uri' => env('DAILY_REPORT_BASE_URL'),
            ]);
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
