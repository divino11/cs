<?php

namespace App\AlertStrategies;

use App\Alert;
use App\Ticker;

class MovingDown extends AbstractChange
{
    public function process(): bool
    {
        return $this->previous * $this->alertValue >= $this->current;
    }
}