<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

final class AlertType extends Enum
{
    const Crossing = 0;
    const Crossing_Up = 1;
    const Crossing_Down = 2;
    const Greater_Than = 3;
    const Less_Than = 4;
    const Percentage = 5;
    const Regular_Update = 6;
    const Volume = 7;
}
