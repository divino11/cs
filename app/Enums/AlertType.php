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
    const Moving_Up = 5;
    const Moving_Down = 6;
    const Moving_Up_Percentage = 7;
    const Moving_Down_Percentage = 8;
    const Regular_Update = 9;

    public static function getDescription($value): string
    {
        switch ($value) {
            case self::Moving_Up_Percentage:
                return 'Moving up %';
                break;
            case self::Moving_Down_Percentage:
                return 'Moving down %';
                break;
            default:
                return parent::getDescription($value);
        }
    }
}
