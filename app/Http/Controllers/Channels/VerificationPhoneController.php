<?php

namespace App\Http\Controllers\Channels;

use App\Http\Requests\Channels\PhoneVerifyRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class VerificationPhoneController extends Controller
{
    public function __invoke(PhoneVerifyRequest $request)
    {
        Auth::user()->markNotificationPhoneAsVerified();

        return view('message', ['message' => 'Notification phone number has been updated']);
    }
}
