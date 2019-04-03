<?php

namespace App\Mail;

use App\Alert;
use App\Ticker;
use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class AlertMailToSms extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * @var Alert
     */
    private $alert;

    private $user;

    private $ticker;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(User $user, Alert $alert, Ticker $ticker)
    {
        $this->user = $user;
        $this->alert = $alert;
        $this->ticker = $ticker;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $this->from(config('mail.from.address'),'CoinSpy Alerts');
        $this->subject("Alert Triggered - {$this->alert->name}");
        $this->to($this->user->routeNotificationForEmailToSms());

        return $this->markdown('emails.alert.triggered_to_sms', [
            'alert' => $this->alert,
            'value' => $this->ticker->getMetric($this->alert->conditions['metric']),
        ]);
    }
}
