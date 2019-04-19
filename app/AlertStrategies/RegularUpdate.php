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

    public function __construct(Alert $alert)
    {
        $this->interval = $alert->conditions['interval'];
        $this->triggered_at = $alert->triggered_at;
    }

    public function process(): bool
    {
        return Carbon::now()->sub(CarbonInterval::make($this->interval)) >= $this->triggered_at;
    }
}