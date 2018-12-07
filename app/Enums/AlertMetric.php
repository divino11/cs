<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

final class AlertMetric extends Enum
{
    const Buy_price = 0;
    const Sell_price = 1;
    const High_price = 2;
    const Low_price = 3;
    const Volume = 4;
}
