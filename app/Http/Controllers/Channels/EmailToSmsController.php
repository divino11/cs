<?php

namespace App\Http\Controllers\Channels;

use App\Http\Controllers\Controller;
use App\Http\Requests\Channels\NotificationEmailToSmsRequest;
use Illuminate\Support\Facades\Auth;

class EmailToSmsController extends Controller
{

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(NotificationEmailToSmsRequest $request)
    {
        $user = Auth::user();
        $user->forceFill([
            'email_to_sms' => $request->email_to_sms,
        ])->save();

        return redirect()->route('channels.index')->with('status', 'Email was saved');
    }
}
