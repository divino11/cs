<?php

namespace App\AlertStrategies;


use App\Alert;
use App\Contracts\AlertStrategy;
use App\Ticker;
use Carbon\Carbon;
use Carbon\CarbonInterval;

class RegularUpdate implements AlertStrategy
{
    private $interval;

    private $triggered_at;

    private $start;

    public function __construct(Alert $alert)
    {
        $this->start = $alert->conditions['starting_date'] . ' ' . $alert->conditions['starting_time'];
        $this->interval = $alert->interval_number . ' ' . $alert->interval_unit;
        $this->triggered_at = $alert->triggered_at;
    }

    public function process(): bool
    {
        if ($this->start >= Carbon::now()) {
            return false;
        }
        return Carbon::now()->sub(CarbonInterval::make($this->interval)) >= $this->triggered_at;
    }
}