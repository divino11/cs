<?php
/**
 * Created by PhpStorm.
 * User: HP440G1
 * Date: 4/17/2019
 * Time: 3:35 PM
 */

namespace App\AlertStrategies;


use App\Alert;
use App\Ticker;

class RegularUpdate extends AbstractRegularUpdate
{
    public function process(Alert $alert, Ticker $ticker): bool
    {
        return parent::process($alert, $ticker);
    }
}