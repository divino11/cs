<?php

namespace App\AlertStrategies;

use App\Alert;
use App\Contracts\AlertStrategy;
use App\Enums\AlertMetric;
use App\Ticker;

class Volume implements AlertStrategy
{
    public function process(Alert $alert, Ticker $ticker) : bool
    {
        $comparison = $ticker->getMetric(AlertMetric::Volume) - $alert->conditions['value'];

        if ($alert->conditions['direction']) {
            return $comparison >= 0;
        }

        return $comparison <= 0;
    }
}