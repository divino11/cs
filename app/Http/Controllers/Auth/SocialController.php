<?php

namespace App\Http\Controllers\Auth;

use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class SocialController extends Controller
{
    public function redirect($provider)
    {
        return Socialite::driver($provider)->redirect();
    }

    public function callback($provider)
    {
        if ($provider == 'twitter') {
            $userSocial = Socialite::driver($provider)->user();
        } else {
            $userSocial = Socialite::driver($provider)->stateless()->user();
        }

        $user = User::where(['email' => $userSocial->getEmail()])->first();
        if ($user) {
            Auth::login($user);
            return redirect('/#');
        } else {
            $emailVerifiedAt = Carbon::now();

            if (!$userSocial->getEmail()) {
                $emailVerifiedAt = null;
            }

            $newUser = User::create([
                'email' => $userSocial->getEmail(),
                'provider_id' => $userSocial->getId(),
                'provider' => $provider,
                'email_verified_at' => $emailVerifiedAt,
            ]);
            Auth::login($newUser);
            return redirect('/#');
        }
    }
}
