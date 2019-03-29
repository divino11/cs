<?php

namespace App\Notifications;

use App\Mail\AlertMailToSms;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Mail;

class EmailToSmsChannel
{
    /**
     * @param $notifiable
     * @param Notification $notification
     * @return mixed
     */
    public function send($notifiable, Notification $notification)
    {
        $message = $notification->toEmailSms($notifiable);
        Mail::send(new AlertMailToSms($notifiable, $message['alert'], $message['ticker']));
    }
}