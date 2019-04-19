<?php

namespace App\AlertStrategies;
use App\Alert;
use App\Ticker;

class LessThan extends AbstractPricePoint
{
    public function process(): bool
    {
        return $this->tickerValue < $this->alertValue;
    }
}