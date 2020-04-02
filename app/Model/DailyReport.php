<?php
namespace App\Model;

use Illuminate\Support\Facades\Log;

class DailyReport
{
    // Count received columns
    private $columns = 0;

    // Object fields
    public $state = NULL;
    public $country = NULL;
    public $update = NULL;
    public $latitude = NULL;
    public $longitude = NULL;
    public $confirmed = NULL;
    public $deaths = NULL;
    public $recovered = NULL;
    public $active = NULL;

    // Expected columns of CSV
    const COLUMN_INDEX = 0;

    const COLUMN_STATE = 2;
    const COLUMN_COUNTRY = 3;
    const COLUMN_UPDATE = 4;
    const COLUMN_LATITUDE = 5;
    const COLUMN_LONGITUDE = 6;
    const COLUMN_CONFIRMED = 7;
    const COLUMN_DEATHS = 8;
    const COLUMN_RECOVERED = 9;
    const COLUMN_ACTIVE = 10;

    public function __construct($raw = NULL)
    {
        if ($raw) {
            $this->columns = count($raw);

            if ($this->columns > self::COLUMN_STATE)
                $this->state = $raw[self::COLUMN_STATE];

            if ($this->columns > self::COLUMN_COUNTRY)
                $this->country = $raw[self::COLUMN_COUNTRY];

            if ($this->columns > self::COLUMN_UPDATE)
                $this->update = $raw[self::COLUMN_UPDATE];

            if ($this->columns > self::COLUMN_LATITUDE)
                $this->latitude = $raw[self::COLUMN_LATITUDE];

            if ($this->columns > self::COLUMN_LONGITUDE)
                $this->longitude = $raw[self::COLUMN_LONGITUDE];

            if ($this->columns > self::COLUMN_CONFIRMED)
                $this->confirmed = $raw[self::COLUMN_CONFIRMED];

            if ($this->columns > self::COLUMN_DEATHS)
                $this->deaths = $raw[self::COLUMN_DEATHS];

            if ($this->columns > self::COLUMN_RECOVERED)
                $this->recovered = $raw[self::COLUMN_RECOVERED];

            if ($this->columns > self::COLUMN_ACTIVE)
                $this->active = $raw[self::COLUMN_ACTIVE];
        }
    }
}