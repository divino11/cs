<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

final class AlertType extends Enum
{
    const Crossed = 0;
    const Crossed_Up = 1;
    const Crossed_Down = 2;
    const Become_Greater_Than = 3;
    const Become_Less_Than = 4;
    const Increased_By = 5;
    const Decreased_By = 6;
    const Regular_Update = 7;
}
