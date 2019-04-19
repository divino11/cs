<?php

namespace App\Contracts;

use App\Alert;
use App\Ticker;

interface AlertStrategy
{
    public function __construct(Alert $alert);

    public function process() : bool;
}