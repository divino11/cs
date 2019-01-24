<?php

namespace App\Notifications;

use App\Alert;
use App\Enums\AlertMetric;
use App\Mail\AlertMail;
use App\Ticker;
use App\User;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\NexmoMessage;
use Illuminate\Notifications\Notifiable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Facades\Auth;
use NotificationChannels\Telegram\TelegramChannel;
use NotificationChannels\Telegram\TelegramMessage;
use Telegram\Bot\Laravel\Facades\Telegram;

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
    public function via($notifiable)
    {
        $available = [];
        if ($notifiable->hasNotificationEmailVerified()) {
            $available[] = 'mail';
        }
        if ($notifiable->hasNotificationPhoneVerified()) {
            $available[] = 'nexmo';
        }
        if ($notifiable->hasNotificationTelegramVerified()) {
            $available[] = TelegramChannel::class;
        }

        $channels = $this->alert->notificationChannels->pluck('notification_channel_name')->toArray();
        return array_merge(['database'], array_intersect($channels, $available));
    }

    public function toMail($notifiable)
    {
        return new AlertMail($notifiable, $this->alert, $this->ticker);
    }

    /**
     * Get the Nexmo / SMS representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return NexmoMessage
     */
    public function toNexmo()
    {
        return (new NexmoMessage)
            ->content(view('alert.description.' . $this->alert->type, ['alert' => $this->alert])->render() . '. The ' . AlertMetric::getDescription((int)$this->alert->conditions['metric']) . ' ' . $this->ticker->getMetric($this->alert->conditions['metric']));
    }

    public function toTelegram($notifiable)
    {
        return TelegramMessage::create()
            ->to($this->alert->user->telegram)
            ->content(view('alert.description.' . $this->alert->type, ['alert' => $this->alert])->render() . '. The ' . AlertMetric::getDescription((int)$this->alert->conditions['metric']) . ' ' . $this->ticker->getMetric($this->alert->conditions['metric']));
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
            'alert_name' => $this->alert->name,
            'alert_description' => view('alert.description.' . $this->alert->type, ['alert' => $this->alert])->render(),
            'ticker_key' => AlertMetric::getDescription((int)$this->alert->conditions['metric']),
            'ticker_value' => $this->ticker->getMetric($this->alert->conditions['metric']),
        ];
    }
}
