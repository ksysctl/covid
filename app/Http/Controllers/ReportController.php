<?php

namespace App\Http\Controllers;

use App\Library\Services\DailyReport;
use DateTime;
use DateInterval;

class ReportController extends Controller
{
    protected $report;

    public function __construct(DailyReport $report)
    {
        $this->report = $report;
    }

    /**
     * Show current report for Costa Rica.
     *
     * @return View
     */
    public function show()
    {
        // Loads latest update
        $date = new DateTime();
        $date->add(
            DateInterval::createFromDateString('yesterday')
        );
        $current = sprintf("%s.csv", $date->format("m-d-Y"));
        $this->report->loadByDate($current);

        // Gets by country
        $report = $this->report->searchByCountry("Costa Rica");

        return view('layouts.report', [
            'report' => $report
        ]);
    }
}
