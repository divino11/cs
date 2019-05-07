<?php

namespace App\AlertStrategies;


use App\Alert;
use App\Ticker;

class IncreasedBy extends AbstractPercentage
{
    public function process(): bool
    {
        return $this->current >= $this->previous * $this->alertValue;
    }
}