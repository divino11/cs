<?php

namespace App\Http\Controllers\Channels;

use App\Http\Requests\Channels\NotificationEmailChangeRequest;
use App\Http\Controllers\Controller;
use App\Mail\ChangeEmailConfirmation;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class NotificationEmailController extends Controller
{

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(NotificationEmailChangeRequest $request)
    {
        $user = Auth::user();
        $user->forceFill([
            'notification_email' => $request->notification_email,
            'notification_email_verified_at' => null
        ])->save();

        Mail::to($user)->send(new ChangeEmailConfirmation($user));

        return redirect()->route('channels')->with('status', 'Email changed');
    }
}
