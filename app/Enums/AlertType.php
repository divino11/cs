<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

final class AlertType extends Enum
{
    const Price_Point = 0;
    const Percentage = 1;
    const Regular_Update = 2;
    const Volume = 3;
}
