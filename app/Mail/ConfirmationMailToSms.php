<?php

namespace App\Mail;

use App\Alert;
use App\Ticker;
use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class ConfirmationMailToSms extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * @var Alert
     */
    private $user;

    private $code;

    /**
     * Create a new message instance.
     *
     * @param User $user
     * @param $code
     */
    public function __construct(User $user, $code)
    {
        $this->user = $user;
        $this->code = $code;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $this->from(config('mail.from.address'),'CoinSpy');
        $this->subject("CoinSpy");
        $this->to($this->user->email_to_sms);

        return $this->markdown('emails.channel.confirm_email_to_sms', [
            'code' => $this->code,
        ]);
    }
}
