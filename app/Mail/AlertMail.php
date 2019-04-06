<?php

namespace App\Mail;

use App\Alert;
use App\Ticker;
use App\User;
use Carbon\CarbonInterval;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\URL;

class AlertMail extends Mailable
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
        $this->subject("CoinSpy Alert: {$this->alert->alert_message}");
        $this->to($this->user->routeNotificationForMail());
        $url = URL::signedRoute('alerts.disable', ['alert' => $this->alert->id]);
        $editUrl = url()->route('alerts.edit', ['alert' => $this->alert->id]);

        return $this->markdown('emails.alert.triggered', [
            'alert' => $this->alert,
            'value' => $this->ticker->getMetric($this->alert->conditions['metric']),
            'disableUrl' => $url,
            'editUrl' => $editUrl,
        ]);
    }
}
