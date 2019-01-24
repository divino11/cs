<?php

namespace App\Http\Controllers\Channels;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ConfirmNotificationPushoverController extends Controller
{
    public function __invoke(Request $request)
    {
        $user = Auth::user();

        if ($request->pushoverVerify != $user->pushover_verification_code) {
            return abort(410, 'Link has expired');
        }

        $user->markNotificationPushoverAsVerified();

        return view('message', ['message' => 'Notification pushover key has been updated']);
    }
}
