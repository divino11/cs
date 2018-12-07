<?php

namespace App\Notifications;

use App\Alert;
use App\Ticker;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Messages\NexmoMessage;
use Illuminate\Notifications\Notifiable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use App\Mail\AlertTriggered as AlertTriggeredMail;

class AlertTriggered extends Notification
{
    use Queueable;

    private $alert;

    private $ticker;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Alert $alert, Ticker $ticker)
    {
        $this->alert = $alert;
        $this->ticker = $ticker;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via(Notifiable $notifiable)
    {
        $available = [];
        if ($notifiable->hasNotificationEmailVerified()) {
            $available[] = 'mail';
        }

        $channels = $this->alert->notificationChannels->pluck('notification_channel_name');

        return array_merge(['database'], array_intersect($available, $channels));
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return new AlertTriggeredMail($notifiable, $this->alert, $this->ticker);
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            'alert' => $this->alert,
            'ticker' => $this->ticker
        ];
    }

    public function toBroadcast($notifiable)
    {
        return new BroadcastMessage([
            'alert' =>  $this->alert,
            'description'   =>  'Alert ' . $this->alert->name . ' has been triggered: ' . $this->info
        ]);
    }

    public function toNexmo($notifiable)
    {
        return (new NexmoMessage)->content($this->alert->name . ':' . $this->info);
    }
}
