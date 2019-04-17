<?php

namespace App\AlertStrategies;

use App\Alert;
use App\Ticker;
use Carbon\Carbon;
use Carbon\CarbonInterval;
use Carbon\CarbonPeriod;

abstract class AbstractPercentage
{
    public function process(Alert $alert, Ticker $ticker) : bool
    {
        $fromDate = Carbon::now()->sub(CarbonInterval::make($alert->conditions['interval']));
        $toDate = $ticker->created_at->sub(new CarbonInterval(0,0,0,0,0,0,1));
        $secondTicker = Ticker::marketLatest($alert->exchange_id, $alert->market_id)->whereBetween('created_at', [$fromDate, $toDate])->latest()->firstOrFail();

        $comparison = 100 * $ticker->getMetric($alert->conditions['metric']) / $secondTicker->getMetric($alert->conditions['metric']) - 100;

        return $comparison;
    }
}