<?php

namespace App\Alerts;

use App\Contracts\AlertCondition;
use App\Enums\AlertMetric;

class PricePointAlert extends AlertCondition
{
    public function getDescription() : string
    {
        $conditions = $this->alert->conditions;
        $metric = strtolower(AlertMetric::getDescription((int)$conditions['metric']));
        $direction = $conditions['direction'] ? 'greater' : 'lower';

        return "$metric is $direction than $conditions[value]";
    }
}