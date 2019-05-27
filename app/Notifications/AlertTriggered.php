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

    public $alert_message;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Alert $alert, Ticker $ticker)
    {
        $this->alert = $alert;
        $this->ticker = $ticker;

        $this->alert_message = str_replace(['{price}', '{volume}'], rtrim($this->ticker->getMetric($this->alert->conditions['metric']), '\0'), $this->alert->alert_message);
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
        return new AlertMail($notifiable, $this->alert, $this->ticker, $this->alert_message);
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
                ->content($this->alert_message)
                ->from('CoinSpy');
        }
    }

    public function toTelegram($notifiable)
    {
        return TelegramMessage::create()
            ->to($this->alert->user->telegram)
            ->content($this->alert_message);
    }

    public function toPushover($notifiable)
    {
        return PushoverMessage::create($this->alert_message)
            ->title('CoinSpy');
    }

    public function toEmailSms($notifiable)
    {
        return [
            'alert' => $this->alert,
            'alert_message' => $this->alert_message,
            'ticker' => $this->ticker,
        ];
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
            'alert' => $this->alert,
            'alert_message' => $this->alert_message,
            'alert_sound' => 'storage/sounds/' . $this->alert->sound,
            'user' => $this->alert
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
            'alert_description' => $this->alert_message,
            'ticker_key' => AlertMetric::getDescription((int)$this->alert->conditions['metric']),
            'ticker_value' => $this->ticker->getMetric($this->alert->conditions['metric']),
        ];
    }
}
