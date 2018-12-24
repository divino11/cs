<?php

namespace App\Http\Controllers\Channels;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ConfirmNotificationEmailController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request, User $user, $email)
    {
        if ($email != $user->notification_email) {
            return abort(410, 'Link has expired');
        }

        $user->markNotificationEmailAsVerified();

        return view('message', ['message' => 'Notification email has been updated']);
    }
}
