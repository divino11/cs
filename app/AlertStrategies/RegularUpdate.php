<?php

namespace App\AlertStrategies;


use App\Alert;
use App\Contracts\AlertStrategy;
use App\Ticker;
use Carbon\Carbon;
use Carbon\CarbonInterval;
use Carbon\CarbonPeriod;

class RegularUpdate implements AlertStrategy
{
    public function process(Alert $alert, Ticker $ticker) : bool
    {
        if (isset($alert->triggered_at))  {
            $fromDate = Carbon::now()->sub(CarbonInterval::make($alert->conditions['interval']));

            $toDate = $alert->triggered_at;

            return $fromDate == $toDate;
        }

        $alert->triggered_at = Carbon::now();
    }
}