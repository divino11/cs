<?php

namespace App\AlertStrategies;

use App\Alert;
use App\Contracts\AlertStrategy;
use App\Ticker;

abstract class AbstractCrossing implements AlertStrategy
{
    protected $currentValue;
    protected $previousValue;
    protected $alertValue;

    public function __construct(Alert $alert)
    {
        $this->alertValue = $alert->conditions['value'];
        $metric = $alert->conditions['metric'];
        list($this->currentValue, $this->previousValue) = Ticker::marketLatest($alert->exchange_id, $alert->market_id)
            ->take(2)
            ->get()
            ->map(function($item) use ($metric){
                return $item->getMetric($metric);
            });
    }

    protected function isCrossingUp() : bool
    {
        return $this->currentValue >= $this->alertValue && $this->previousValue <= $this->alertValue;
    }

    protected function isCrossingDown() : bool
    {
        return $this->previousValue >= $this->alertValue && $this->currentValue <= $this->alertValue;
    }
}