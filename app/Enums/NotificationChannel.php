<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

final class NotificationChannel extends Enum
{
    const Mail = 1;
    const Sms = 2;
    const Telegram = 3;
    const Pushover = 4;
}
