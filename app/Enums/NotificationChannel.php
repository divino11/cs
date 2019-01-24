<?php

namespace App\Enums;

use BenSampo\Enum\Enum;
use NotificationChannels\Pushover\PushoverChannel;
use NotificationChannels\Telegram\TelegramChannel;

final class NotificationChannel extends Enum
{
    const Mail = 1;
    const Nexmo = 2;
    const Telegram = 3;
    const Pushover = 4;

    public static function getDescription($value): string
    {
        switch ($value) {
            case self::Mail:
                return 'mail';
                break;
            case self::Nexmo:
                return 'nexmo';
                break;
            case self::Telegram:
                return TelegramChannel::class;
                break;
            case self::Pushover:
                return PushoverChannel::class;
                break;
            default:
                return self::getKey($value);
        }
    }
}
