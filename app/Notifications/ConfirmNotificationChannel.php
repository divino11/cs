<?php

namespace App\Notifications;

use App\Mail\UserNotificationChannelConfirmation;
use App\UserNotificationChannel;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\NexmoMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class ConfirmNotificationChannel extends Notification
{
    use Queueable;


    private $channel;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(UserNotificationChannel $channel)
    {
        $this->channel = $channel;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return [$this->channel->notificationChannel->driver];
    }

    public function toMail($notifiable)
    {
        return new UserNotificationChannelConfirmation($this->channel);
    }

    public function toNexmo($notifiable)
    {
        return (new NexmoMessage())->content('Coinspy confirmation code: '. $this->channel->confirmation_code);
    }
}
