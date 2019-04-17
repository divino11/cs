<?php
/**
 * Created by PhpStorm.
 * User: HP440G1
 * Date: 4/17/2019
 * Time: 3:27 PM
 */

namespace App\AlertStrategies;


use App\Alert;
use App\Ticker;

class FallsBy extends AbstractPercentage
{
    public function process(Alert $alert, Ticker $ticker): bool
    {
        $comparison = parent::process($alert, $ticker);
        $sign = -1;
        return $comparison * $sign >= $alert->conditions['value'];
    }
}