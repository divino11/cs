<?php

namespace App\AlertStrategies;

use App\Alert;
use App\Ticker;

abstract class AbstractCrossing
{
    public function process(Alert $alert, Ticker $ticker)
    {
        $tickers = Ticker::marketLatest($alert->exchange_id, $alert->market_id)->latest()->take(2)->get();

        $currentTicker = $tickers[0]->getMetric($alert->conditions['metric']);
        $previousTicker = $tickers[1]->getMetric($alert->conditions['metric']);

        return [$currentTicker, $previousTicker];
    }
}