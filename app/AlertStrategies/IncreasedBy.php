<?php
/**
 * Created by PhpStorm.
 * User: HP440G1
 * Date: 4/17/2019
 * Time: 3:22 PM
 */

namespace App\AlertStrategies;


use App\Alert;
use App\Ticker;

class IncreasedBy extends AbstractPercentage
{
    public function process(Alert $alert, Ticker $ticker): bool
    {
        $comparison = parent::process($alert, $ticker);
        return $comparison >= $alert->conditions['value'];
    }
}