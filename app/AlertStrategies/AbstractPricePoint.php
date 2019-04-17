<?php

namespace App\AlertStrategies;

use App\Alert;
use App\Ticker;

abstract class AbstractPricePoint
{
    public function process(Alert $alert, Ticker $ticker)
    {
        return $ticker->getMetric($alert->conditions['metric']) - $alert->conditions['value'];
    }
}