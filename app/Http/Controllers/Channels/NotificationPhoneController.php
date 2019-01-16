<?php

namespace App\Http\Controllers\Channels;

use App\Http\Requests\Channels\NotificationPhoneChangeRequest;
use App\Http\Controllers\Controller;
use App\Mail\ChangeEmailConfirmation;
use App\Notifications\SetPhoneNumber;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Nexmo\Laravel\Facade\Nexmo;

class NotificationPhoneController extends Controller
{

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(NotificationPhoneChangeRequest $request)
    {
        $user = Auth::user();

        $phoneVerifyNumber = rand(1000, 9999);

        $user->forceFill([
            'phone' => $request->notification_phone,
            'phoneVerifyNumber' => $phoneVerifyNumber,
            'phone_verified_at' => null
        ])->save();

        $this->sendMessage($request->notification_phone, $phoneVerifyNumber);

        $user->notify(new SetPhoneNumber($user->email));

        return redirect()->route('channels')->with('status', 'Please check your phone for a verification text message.');
    }

    public function resendCode()
    {
        $user = Auth::user();

        $phoneVerifyNumber = rand(1000, 9999);

        $user->forceFill([
            'phoneVerifyNumber' => $phoneVerifyNumber,
            'phone_verified_at' => null
        ])->save();

        $this->sendMessage($user->phone, $phoneVerifyNumber);

        return redirect()->route('channels')->with('status', 'Verification code resent. Please check your phone.');
    }

    public function destroy()
    {
        $user = Auth::user();
        $user->forceFill([
            'phone' => null,
            'phoneVerifyNumber' => null,
            'phone_verified_at' => null
        ])->save();

        return redirect()->route('channels')->with('status', 'Phone was removed');
    }

    public function verifyPhoneNumber(NotificationPhoneChangeRequest $request)
    {
        $user = Auth::user();

        if ($request->phoneVerify != $user->phoneVerifyNumber) {
            return redirect()->route('channels')->with('status', 'Verification number is incorrect');
        }

        $user->markNotificationPhoneAsVerified();

        return redirect()->route('channels')->with('status', 'Your phone number has been verified.');
    }

    public function sendMessage($phone, $phoneVerifyNumber)
    {
        Nexmo::message()->send([
            'to' => $phone,
            'from' => 'CoinSpy',
            'text' => 'CoinSpy - your verification code is: ' . $phoneVerifyNumber
        ]);
    }
}
