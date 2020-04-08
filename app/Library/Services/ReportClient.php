<?php

namespace App\Library\Services;

use App;
use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use Illuminate\Support\Facades\Log;
use App\Library\Services\DailyReport\Helper;

class ReportClient extends Client
{
    function __construct()
    {
        if (App::environment('testing')) {
            Log::debug("Uses mock Report Client");

            $config = [
                'handler' => new MockHandler(Helper::mock())
            ];
        } else {
            $config = [
                'headers' => [
                    'Accept' => 'text/csv',
                ],
                'stream' => true,
                'timeout' => env('DAILY_REPORT_TIMEOUT'),
                'base_uri' => env('DAILY_REPORT_BASE_URL'),
            ];
        }

        parent::__construct($config);
    }
}