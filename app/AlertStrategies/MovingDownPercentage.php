<?php

namespace App\AlertStrategies;

use App\Alert;
use App\Ticker;

class MovingDownPercentage extends AbstractChange
{
    public function process(): bool
    {
        return abs(100 - 100 * $this->current / $this->previous) >= $this->alertValue;
    }
}