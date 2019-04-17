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
    const Increased_By = 5;
    const Falls_By = 6;
    const Regular_Update = 7;
}
