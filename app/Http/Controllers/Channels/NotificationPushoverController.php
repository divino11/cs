<?php

namespace App\Http\Controllers\Channels;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Notifications\ConfirmNotificationChannel;
use Illuminate\Support\Facades\Auth;
use NotificationChannels\Pushover\PushoverChannel;

class NotificationPushoverController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = Auth::user();

        $pushoverVerifyNumber = rand(1000, 9999);

        $user->forceFill([
            'pushover' => $request->notification_pushover,
            'pushover_verification_code' => $pushoverVerifyNumber,
            'pushover_verified_at' => null
        ])->save();

        $user->notify(new ConfirmNotificationChannel(PushoverChannel::class, $pushoverVerifyNumber));

        return redirect()->route('channels')->with('status', 'Please check your phone for a verification text message.');
    }

    public function update()
    {
        $user = Auth::user();

        $pushoverVerifyNumber = rand(1000, 9999);

        $user->forceFill([
            'pushover_verification_code' => $pushoverVerifyNumber,
            'pushover_verified_at' => null
        ])->save();

        $user->notify(new ConfirmNotificationChannel(PushoverChannel::class, $pushoverVerifyNumber));

        return redirect()->route('channels')->with('status', 'Verification code resent. Please check your phone.');
    }

    public function destroy()
    {
        $user = Auth::user();

        $user->forceFill([
            'pushover' => null,
            'pushover_verification_code' => null,
            'pushover_verified_at' => null
        ])->save();

        return redirect()->route('channels')->with('status', 'Key was removed');
    }
}
