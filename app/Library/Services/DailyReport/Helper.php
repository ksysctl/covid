<?php

namespace App\Library\Services\DailyReport;

use GuzzleHttp\Psr7\Response;
use Illuminate\Http\Response as Responses;

class Helper
{
    CONST FIXTURES_PATH = "tests/Feature/fixtures/report/";

    public static function mock()
    {
        return [
            new Response(
                Responses::HTTP_OK, [],
                file_get_contents(
                    sprintf("%sdaily.csv", base_path(self::FIXTURES_PATH))
                )
            ),
        ];
    }
}