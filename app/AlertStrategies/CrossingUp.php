<?php
/**
 * Created by PhpStorm.
 * User: HP440G1
 * Date: 4/17/2019
 * Time: 12:13 PM
 */

namespace App\AlertStrategies;


use App\Alert;
use App\Ticker;

class CrossingUp extends AbstractCrossing
{
    public function process(Alert $alert, Ticker $ticker)
    {
        $tickers = parent::process($alert, $ticker);

        return $tickers[0] >= $alert->conditions['value'] && $tickers[1] <= $alert->conditions['value'];
    }
}