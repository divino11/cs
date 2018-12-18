<?php

namespace App\Contracts;

use App\Alert;
use App\Ticker;

interface AlertStrategy
{
    public function process(Alert $alert, Ticker $ticker) : bool;
}