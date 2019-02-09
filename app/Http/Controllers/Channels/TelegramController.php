<?php

namespace App\Http\Controllers\Channels;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class TelegramController extends Controller
{
    public function __invoke()
    {
        $user = Auth::user();

        $user->forceFill([
            'telegram' => null,
            'telegram_verification_code' => rand(100000, 999999),
            'telegram_verified_at' => null
        ])->save();

        return redirect()->route('channels.index')->with('status', 'Verification code change');
    }
}
