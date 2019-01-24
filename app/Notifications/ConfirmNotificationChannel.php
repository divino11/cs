<?php

namespace App\Notifications;

use App\Mail\UserNotificationChannelConfirmation;
use App\UserNotificationChannel;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\NexmoMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use NotificationChannels\Pushover\PushoverMessage;

class ConfirmNotificationChannel extends Notification
{
    use Queueable;

    private $verifyCode;

    private $channel;

    /**
     * Create a new notification instance.
     *
     * @param $channel
     * @param null $verifyCode
     */
    public function __construct($channel, $verifyCode = null)
    {
        $this->channel = $channel;
        $this->verifyCode = $verifyCode;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return [$this->channel];
    }

    public function toMail($notifiable)
    {
        return new UserNotificationChannelConfirmation($this->channel);
    }

    public function toNexmo($notifiable)
    {
        return (new NexmoMessage())->content('CoinSpy - your verification code is: ' . $this->verifyCode);
    }

    public function toPushover($notifiable)
    {
        return PushoverMessage::create('CoinSpy - your verification code is: ' . $this->verifyCode)
            ->title('CoinSpy');
    }
}
