<?php

namespace App\Http\Controllers\Channels;

use App\Http\Requests\Channels\PhoneVerifyRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Nexmo\Laravel\Facade\Nexmo;

class PhoneVerificationController extends Controller
{
    public function store(PhoneVerifyRequest $request)
    {
        Auth::user()->markNotificationPhoneAsVerified();

        return redirect()->route('channels.index')->with('status', 'Your phone number has been verified');;
    }

    public function update()
    {
        $user = Auth::user();

        $phoneVerifyNumber = rand(1000, 9999);

        $user->forceFill([
            'phone_verification_code' => $phoneVerifyNumber,
            'phone_verified_at' => null
        ])->save();

        $this->sendMessage($user->phone, $phoneVerifyNumber);

        return redirect()->route('channels.index')->with('status', 'Verification code resent. Please check your phone.');
    }

    private function sendMessage($phone, $phoneVerifyNumber)
    {
        return Nexmo::message()->send([
            'to' => $phone,
            'from' => 'Nexmo',
            'text' => 'CoinSpy - your verification code is: ' . $phoneVerifyNumber
        ]);
    }
}
