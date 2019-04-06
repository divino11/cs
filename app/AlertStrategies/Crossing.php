<?php

namespace App\AlertStrategies;

use App\Alert;
use App\Contracts\AlertStrategy;
use App\Ticker;

class Crossing implements AlertStrategy
{
    public function process(Alert $alert, Ticker $ticker) : bool
    {
        $firstTicker = Ticker::marketLatest($alert->exchange_id, $alert->market_id)->latest()->take(2)->get()[0];
        $secondTicker = Ticker::marketLatest($alert->exchange_id, $alert->market_id)->latest()->take(2)->get()[1];

        $currentTicker = $firstTicker->getMetric($alert->conditions['metric']);
        $previousTicker = $secondTicker->getMetric($alert->conditions['metric']);

        if (($currentTicker <= $alert->conditions['value'] && $previousTicker <= $alert->conditions['value']) ||
            ($currentTicker >= $alert->conditions['value'] && $previousTicker >= $alert->conditions['value'])) {
            return false;
        }

        if ($alert->conditions['direction']) {
            return $currentTicker <= $alert->conditions['value'] && $previousTicker >= $alert->conditions['value'];
        }

        return $currentTicker >= $alert->conditions['value'] && $previousTicker <= $alert->conditions['value'];
    }
}