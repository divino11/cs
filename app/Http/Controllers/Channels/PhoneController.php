<?php

namespace App\Http\Controllers\Channels;

use App\Http\Requests\Channels\NotificationPhoneChangeRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Nexmo\Laravel\Facade\Nexmo;

class PhoneController extends Controller
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
            'phone' => preg_replace('/\D/', '', $request->notification_phone),
            'phone_verification_code' => $phoneVerifyNumber,
            'phone_verified_at' => null
        ])->save();

        $this->sendMessage($request->notification_phone, $phoneVerifyNumber);

        return redirect()->route('channels.index')->with('status', 'Please check your phone for a verification text message.');
    }


    public function destroy()
    {
        $user = Auth::user();
        $user->forceFill([
            'phone' => null,
            'phone_verification_code' => null,
            'phone_verified_at' => null
        ])->save();

        return redirect()->route('channels.index')->with('status', 'Phone was removed');
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
