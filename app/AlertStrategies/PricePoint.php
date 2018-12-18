<?php

namespace App\AlertStrategies;

use App\Alert;
use App\Contracts\AlertStrategy;
use App\Ticker;

class PricePoint implements AlertStrategy
{
    public function process(Alert $alert, Ticker $ticker) : bool
    {
        $comparison = $ticker->getMetric($alert->conditions['metric']) - $alert->conditions['value'];

        if ($alert->conditions['direction']) {
            return $comparison >= 0;
        }

        return $comparison <= 0;

    }
}