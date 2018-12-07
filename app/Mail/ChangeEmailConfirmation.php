<?php

namespace App\Mail;

use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\URL;

class ChangeEmailConfirmation extends Mailable
{
    use Queueable, SerializesModels;

    private $user;

    private $email;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(User $user, $email)
    {
        $this->user = $user;
        $this->email = $email;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $url = URL::temporarySignedRoute('users.email.change', now()->addHour(), [
            'user' => $this->user,
            'email' => $this->email
        ]);
        return $this
            ->to($this->email)
            ->markdown('emails.user.change_email', ['url' => $url, 'user' => $this->user]);
    }
}
