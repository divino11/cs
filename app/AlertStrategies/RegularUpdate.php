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
        $fromDate = Carbon::now()->sub(CarbonInterval::make($alert->conditions['interval']));
        $toDate = $ticker->created_at->sub(new CarbonInterval(0,0,0,0,0,0,1));

        return $toDate == $fromDate;
    }
}