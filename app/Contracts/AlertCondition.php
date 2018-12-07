<?php

namespace App\Contracts;

use App\Alert;

abstract class AlertCondition
{
    protected $alert;

    public function __construct(Alert $alert)
    {
        $this->alert = $alert;
    }

    abstract public function getDescription(): string;
}