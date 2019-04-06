<?php

namespace App\AlertStrategies;

use App\Alert;
use App\Contracts\AlertStrategy;
use App\Ticker;

class Crossing implements AlertStrategy
{
    public function process(Alert $alert, Ticker $ticker) : bool
    {
        $tickers = Ticker::marketLatest($alert->exchange_id, $alert->market_id)->latest()->take(2)->get();

        $currentTicker = $tickers[0]->getMetric($alert->conditions['metric']);
        $previousTicker = $tickers[1]->getMetric($alert->conditions['metric']);

        if ($alert->conditions['direction'] == 1) {
            return $currentTicker >= $alert->conditions['value'] && $previousTicker <= $alert->conditions['value'];
        }

        if ($alert->conditions['direction'] == 2) {
            return $currentTicker <= $alert->conditions['value'] && $previousTicker >= $alert->conditions['value'];
        }

        return ($currentTicker >= $alert->conditions['value'] && $previousTicker <= $alert->conditions['value']) ||
                ($currentTicker <= $alert->conditions['value'] && $previousTicker >= $alert->conditions['value']);
    }
}