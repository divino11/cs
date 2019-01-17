<?php

namespace App\Http\Controllers\Channels;

use App\Http\Requests\Channels\PhoneVerifyRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class VerificationPhoneController extends Controller
{
    public function __invoke(PhoneVerifyRequest $request)
    {
        $user = Auth::user();

        $user->markNotificationPhoneAsVerified();

        return redirect()->route('channels')->with('status', 'Your phone number has been verified.');
    }
}
