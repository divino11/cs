<?php

namespace App\Http\Controllers\Channels;

use App\Http\Requests\Channels\NotificationEmailToSmsRequest;
use App\Http\Controllers\Controller;
use App\Mail\AlertMailToSms;
use App\Mail\ConfirmationMailToSms;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class EmailToSmsController extends Controller
{

    /**
     * Store a newly created resource in storage.
     *
     * @param NotificationEmailToSmsRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(NotificationEmailToSmsRequest $request)
    {
        $user = Auth::user();

        $phoneVerifyNumber = rand(1000, 9999);

        $user->forceFill([
            'email_to_sms' => $request->email_to_sms,
            'email_to_sms_verification_code' => $phoneVerifyNumber,
            'email_to_sms_verified_at' => null
        ])->save();

        $this->sendMessage($user, $phoneVerifyNumber);

        return redirect()->route('channels.index')->with('status', 'Please check your phone for a verification text message.');
    }


    public function destroy()
    {
        $user = Auth::user();
        $user->forceFill([
            'email_to_sms' => null,
            'email_to_sms_verification_code' => null,
            'email_to_sms_verified_at' => null
        ])->save();

        return redirect()->route('channels.index')->with('status', 'Email-To-Sms address was removed');
    }

    private function sendMessage($user, $phoneVerifyNumber)
    {
        Mail::send(new ConfirmationMailToSms($user, $phoneVerifyNumber));
    }
}
