<?php

namespace App\Notifications;

use App\Alert;
use App\Enums\AlertMetric;
use App\Mail\AlertMail;
use App\Ticker;
use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Messages\NexmoMessage;
use Illuminate\Notifications\Notification;
use Nexmo\Laravel\Facade\Nexmo;
use NotificationChannels\Telegram\TelegramMessage;
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
                return $notifiable->routeNotificationFor($channel->notification_channel_name) or
                    $notifiable->receivesBroadcastNotificationsOn();
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
    public function toNexmo($notifiable)
    {
        if ($this->alert->user->sms > 0) {
            User::find($this->alert->user->id)
                ->decrement('sms', 1);
            return (new NexmoMessage)
                ->content($this->alert->name . '. ' . view('alert.description.' . $this->alert->type, ['alert' => $this->alert])->render() . '. The ' . AlertMetric::getDescription((int)$this->alert->conditions['metric']) . ' ' . $this->ticker->getMetric($this->alert->conditions['metric']))
                ->from('CoinSpy');
        }
    }

    public function toTelegram($notifiable)
    {
        return TelegramMessage::create()
            ->to($this->alert->user->telegram)
            ->content($this->alert->name . '. ' . view('alert.description.' . $this->alert->type, ['alert' => $this->alert])->render() . '. The ' . AlertMetric::getDescription((int)$this->alert->conditions['metric']) . ' ' . $this->ticker->getMetric($this->alert->conditions['metric']));
    }

    public function toPushover($notifiable)
    {
        return PushoverMessage::create($this->alert->name . '. ' . view('alert.description.' . $this->alert->type, ['alert' => $this->alert])->render() . '. The ' . AlertMetric::getDescription((int)$this->alert->conditions['metric']) . ' ' . $this->ticker->getMetric($this->alert->conditions['metric']))
            ->title('CoinSpy');
    }

    /**
     * Get the broadcastable representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return BroadcastMessage
     */
    public function toBroadcast($notifiable)
    {
        return new BroadcastMessage([
            'alert_name' => $this->alert->name,
            'alert_type' => AlertMetric::getDescription((int)$this->alert->conditions['metric']),
            'alert_sound' => 'storage/sounds/' . $this->alert->user->sound,
            'value' => $this->ticker->getMetric($this->alert->conditions['metric']),
            'user' => $this->alert->user
        ]);
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
