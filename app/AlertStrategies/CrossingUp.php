<?php

namespace App\AlertStrategies;

use App\Alert;
use App\Ticker;

class CrossingUp extends AbstractCrossing
{
    public function process() : bool
    {
        return $this->isCrossingUp();
    }
}