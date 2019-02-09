<?php

namespace App\Http\Controllers\Channels;

use App\Http\Requests\Channels\PushoverVerifyRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class PushoverVerificationController extends Controller
{
    public function __invoke(PushoverVerifyRequest $request)
    {
        Auth::user()->markNotificationPushoverAsVerified();

        return view('message', ['message' => 'Notification pushover key has been updated']);
    }
}
