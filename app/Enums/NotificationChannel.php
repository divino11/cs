<?php

namespace App\Enums;

use App\Events\AlertNotification;
use App\Notifications\EmailToSmsChannel;
use BenSampo\Enum\Enum;
use Illuminate\Notifications\Messages\BroadcastMessage;
use NotificationChannels\Telegram\TelegramChannel;
use NotificationChannels\Pushover\PushoverChannel;

final class NotificationChannel extends Enum
{
    const Mail = 1;
    const Nexmo = 2;
    const Telegram = 3;
    const Pushover = 4;
    const Browser_Alert = 5;
    const Email_To_Sms = 6;

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
            case self::Browser_Alert:
                return 'broadcast';
                break;
            case self::Email_To_Sms:
                return EmailToSmsChannel::class;
                break;
            default:
                return self::getKey($value);
        }
    }
}
