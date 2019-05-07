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
    const Increased_By_Percentage = 5;
    const Decreased_By_Percentage = 6;
    const Increased_By = 7;
    const Decreased_By = 8;
    const Regular_Update = 9;

    public static function getDescription($value): string
    {
        switch ($value) {
            case self::Increased_By_Percentage:
                return 'Increased By %';
                break;
            case self::Decreased_By_Percentage:
                return 'Decreased By %';
                break;
            default:
                return parent::getDescription($value);
        }
    }
}
