<?php

namespace App\AlertStrategies;

use App\Alert;
use App\Ticker;

class FallsBy extends AbstractPercentage
{
    public function process(): bool
    {
        return abs(100 - 100 * $this->current / $this->previous) >= $this->alertValue;
    }
}