<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

final class AlertMetric extends Enum
{
    const Price = 0;
    const Volume = 1;

    public static function getDescription($value): string
    {
        switch ($value) {
            case self::Volume:
                return 'Volume (24h)';
                break;
            default:
                return self::getKey($value);
        }
    }
}
