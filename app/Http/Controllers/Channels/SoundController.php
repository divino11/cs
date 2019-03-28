<?php

namespace App\Http\Controllers\Channels;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;

class SoundController extends Controller
{

    /**
     * Store a newly created resource in storage.
     *
     * @param User $user
     * @return void
     */
    public function soundEnable(User $user)
    {
        $user->soundEnableToggle()->save();

    }

    public function sound(User $user, Request $request)
    {
        $user->forceFill([
            'sound' => $request->sound,
        ])->save();
    }
}
