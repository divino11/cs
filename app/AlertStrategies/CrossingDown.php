<?php

namespace App\AlertStrategies;

use App\Alert;
use App\Ticker;

class CrossingDown extends AbstractCrossing
{
    public function process() : bool
    {
        return $this->isCrossingDown();
    }
}