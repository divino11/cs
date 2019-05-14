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
        Mail::raw('CoinSpy Alert: ' . $message['alert_message'], function ($message) use ($notifiable) {
           $message->to($notifiable->email_to_sms);
        });
    }
}