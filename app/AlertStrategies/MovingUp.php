<?php

namespace App\AlertStrategies;


use App\Alert;
use App\Ticker;

class MovingUp extends AbstractChange
{
    public function process(): bool
    {
        return $this->current >= $this->previous * $this->alertValue;
    }
}