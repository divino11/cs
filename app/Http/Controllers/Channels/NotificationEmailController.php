<?php

namespace App\Http\Controllers\Channels;

use App\Http\Requests\Channels\NotificationEmailChangeRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

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
        Auth::user()->forceFill([
            'notification_email' => $request->notification_email,
            'notification_email_verified_at' => null
        ])->save();

        return redirect()->route('channels')->with('status', 'Email changed');
    }
}
