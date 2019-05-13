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

    private $alert_message;

    private $user;

    private $ticker;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(User $user, Alert $alert, $alert_message, Ticker $ticker)
    {
        $this->user = $user;
        $this->alert = $alert;
        $this->alert_message = $alert_message;
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
        $this->subject("CoinSpy Alert: {$this->alert_message}");
        $this->to($this->user->routeNotificationForEmailToSms());

        return $this->text('emails.alert.triggered_to_sms', [
            'alert_message' => $this->alert_message,
        ]);
    }
}
