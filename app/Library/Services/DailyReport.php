<?php

namespace App\Library\Services;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use App\Model\DailyReport as DailyReportModel;

class DailyReport
{
    // Http client to fetch external resource
    private $client;

    // CSV response
    private $raw = [];

    // Cache settings
    const CACHE_KEY_RAW = "DAILY_REPORT_RAW";
    const CACHE_KEY_TTL = 1440;

    public function __construct()
    {
        $this->client = app(Client::class);
    }

    public function getRaw()
    {
        if (Cache::has(self::CACHE_KEY_RAW)) {
            $raw = Cache::get(self::CACHE_KEY_RAW, []);
        } else {
            $raw = $this->raw;
        }
        Log::debug(sprintf("Found %d records", count($raw)));

        return $raw;
    }

    public function setRaw($value)
    {
        $this->raw = $value;

        Cache::put(
            self::CACHE_KEY_RAW,
            $this->raw,
            self::CACHE_KEY_TTL
        );
    }

    public function loadByDate($url)
    {
        // Retrieve from cache if already exists
        $raw = self::getRaw();
        if ($raw)
            return $raw;

        // Fetch from external source
        Log::debug(sprintf("Request to %s", $url));
        try {
            $response = $this->client->request('GET', $url);
        } catch (\Exception $e) {
            Log::error(sprintf("Error on request %s", $e));

            return [];
        }

        $res = $response->getBody()->getContents();
        Log::debug(sprintf("Got response %s", $res));

        // Set cache with new content
        self::setRaw(self::parse($res));
        return $this->raw;
    }

    public function searchByCountry($value) {
        $record = NULL;
        $raw = self::getRaw();

        // Process only if there are records
        if (count($raw) < 1) {
            Log::debug(sprintf("Payload is empty on search by country"));
            return $record;
        }

        // Search country by column Country_Region (offset 3)
        $i = array_keys(array_column(
            $raw, DailyReportModel::COLUMN_COUNTRY
        ), $value);

        // If found then fetch all information by row index
        if (empty($i)) {
            Log::debug(sprintf("Record not found by country %s", $value));
            return $record;
        }

        $record = new DailyReportModel(
            $raw[$i[DailyReportModel::COLUMN_INDEX]]
        );

        return $record;
    }

    private function parse($content) {
        $lines = explode(PHP_EOL, $content);

        $records = array();
        foreach ($lines as $row) {
            $records[] = str_getcsv($row);
        }

        return $records;
    }
}