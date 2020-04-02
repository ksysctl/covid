<?php

namespace App\Library\Services;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;
use App\Model\DailyReport as DailyReportModel;

class DailyReport
{
    // Http client to fetch external resource
    private $client;

    // CSV response & size
    private $raw = [];
    private $count = 0;

    public function __construct()
    {
        $this->client = app(Client::class);
    }

    public function loadByDate($url)
    {
        Log::debug(sprintf("Request to %s", $url));
        try {
            $response = $this->client->request('GET', $url);
        } catch (\Exception $e) {
            Log::error(sprintf("Error on request %s", $e));

            return [];
        }

        $res = $response->getBody()->getContents();
        Log::debug(sprintf("Got response %s", $res));

        self::parse($res);
        Log::debug(sprintf("Found %d records", $this->count));

        return $this->raw;
    }

    public function searchByCountry($value) {
        $record = NULL;

        // Process only if there are records
        if ($this->count < 1) {
            Log::debug(sprintf("Payload is empty"));
            return $record;
        }

        // Search country by column Country_Region (offset 3)
        $i = array_keys(array_column(
            $this->raw, DailyReportModel::COLUMN_COUNTRY
        ), $value);

        // If found then fetch all information by row index
        if (empty($i)) {
            Log::debug(sprintf("Record not found by country %s", $value));
            return $record;
        }

        $record = new DailyReportModel(
            $this->raw[$i[DailyReportModel::COLUMN_INDEX]]
        );

        return $record;
    }

    private function parse($content) {
        $lines = explode(PHP_EOL, $content);

        $records = array();
        foreach ($lines as $row) {
            $records[] = str_getcsv($row);
        }

        $this->count = count($records);
        $this->raw = $records;
    }
}