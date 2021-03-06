<?php

namespace App\Http\Controllers\Channels;

use App\Http\Requests\Channels\EmailToSmsVerifyRequest;
use App\Http\Controllers\Controller;
use App\Mail\ConfirmationMailToSms;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class EmailToSmsVerificationController extends Controller
{
    public function store(EmailToSmsVerifyRequest $request)
    {
        Auth::user()->markNotificationEmailToSmsAsVerified();

        return redirect()->route('channels.index')->with('status', 'Your Email-To-Sms address has been verified');
    }

    public function update()
    {
        $user = Auth::user();

        $phoneVerifyNumber = rand(1000, 9999);

        $user->forceFill([
            'email_to_sms_verification_code' => $phoneVerifyNumber,
            'email_to_sms_verified_at' => null
        ])->save();

        Mail::raw("CoinSpy - your verification code is: " . $phoneVerifyNumber, function ($message) use ($user) {
            $message->to($user->email_to_sms);
        });

        return redirect()->route('channels.index')->with('status', 'Verification code resent. Please check your phone.');
    }
}
