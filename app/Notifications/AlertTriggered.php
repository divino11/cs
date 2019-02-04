<?php

namespace App\Notifications;

use App\Alert;
use App\Enums\AlertMetric;
use App\Enums\NotificationChannel;
use App\Mail\AlertMail;
use App\Ticker;
use App\User;
use BenSampo\Enum\Enum;
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
use NotificationChannels\Pushover\PushoverChannel;
use NotificationChannels\Pushover\PushoverMessage;

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
        return $this->alert->notificationChannels
            ->filter(function ($channel) use ($notifiable) {
                return $notifiable->routeNotificationFor($channel->notification_channel_name);
            })->pluck('notification_channel_description')->push('database')->toArray();
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
        if ($this->alert->user->sms > 0) {
            User::find($this->alert->user->id)
                ->decrement('sms', 1);
            return (new NexmoMessage)
                ->content(view('alert.description.' . $this->alert->type, ['alert' => $this->alert])->render() . '. The ' . AlertMetric::getDescription((int)$this->alert->conditions['metric']) . ' ' . $this->ticker->getMetric($this->alert->conditions['metric']));
        } else {
            return false;
        }

    }

    public function toTelegram($notifiable)
    {
        return TelegramMessage::create()
            ->to($this->alert->user->telegram)
            ->content(view('alert.description.' . $this->alert->type, ['alert' => $this->alert])->render() . '. The ' . AlertMetric::getDescription((int)$this->alert->conditions['metric']) . ' ' . $this->ticker->getMetric($this->alert->conditions['metric']));
    }

    public function toPushover($notifiable)
    {
        return PushoverMessage::create(view('alert.description.' . $this->alert->type, ['alert' => $this->alert])->render() . '. The ' . AlertMetric::getDescription((int)$this->alert->conditions['metric']) . ' ' . $this->ticker->getMetric($this->alert->conditions['metric']))
            ->title('CoinSpy');
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
