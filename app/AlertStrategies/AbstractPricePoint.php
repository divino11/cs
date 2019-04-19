<?php

namespace App\AlertStrategies;

use App\Alert;
use App\Contracts\AlertStrategy;
use App\Ticker;

abstract class AbstractPricePoint implements AlertStrategy
{
    protected $tickerValue;

    protected $alertValue;

    public function __construct(Alert $alert)
    {
        $this->tickerValue = Ticker::marketLatest($alert->exchange_id, $alert->market_id)
            ->firstOrFail()
            ->getMetric($alert->conditions['metric']);
        $this->alertValue = $alert->conditions['value'];
    }
}