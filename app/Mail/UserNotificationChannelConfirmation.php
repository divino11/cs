<?php

namespace App\Mail;

use App\UserNotificationChannel;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\URL;

class UserNotificationChannelConfirmation extends Mailable
{
    use Queueable, SerializesModels;

    private $channel;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(UserNotificationChannel $channel)
    {
        $this->channel = $channel;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $this->to($this->channel->recipient);
        return $this->markdown('emails.channel.confirm', [
            'channel' => $this->channel,
            'url' => URL::signedRoute('channels.confirm', ['userNotificationChannel' => $this->channel->id])
        ]);
    }
}
