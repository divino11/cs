<?php

namespace App\AlertStrategies;


use App\Alert;
use App\Ticker;

class IncreasedBy extends AbstractPercentage
{
    public function process(): bool
    {
        return (100 * $this->current / $this->previous - 100) >= $this->alertValue;
    }
}