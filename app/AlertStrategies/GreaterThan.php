<?php
/**
 * Created by PhpStorm.
 * User: HP440G1
 * Date: 4/16/2019
 * Time: 3:15 PM
 */

namespace App\AlertStrategies;
use App\Alert;
use App\Ticker;

class GreaterThan extends AbstractPricePoint
{
    public function process(Alert $alert, Ticker $ticker): bool
    {
        return parent::process($alert, $ticker) >= 0;
    }
}