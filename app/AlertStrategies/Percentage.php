<?php

namespace App\AlertStrategies;


use App\Alert;
use App\Contracts\AlertStrategy;
use App\Ticker;

class Percentage implements AlertStrategy
{
    public function process(Alert $alert, Ticker $ticker) : bool
    {
        return false;
    }
}