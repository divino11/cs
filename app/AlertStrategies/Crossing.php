<?php

namespace App\AlertStrategies;
use App\Alert;
use App\Ticker;

class Crossing extends AbstractCrossing
{
    public function process() : bool
    {
        return $this->isCrossingDown() || $this->isCrossingUp();
    }
}