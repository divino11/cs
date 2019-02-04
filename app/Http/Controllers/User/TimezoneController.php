<?php

namespace App\Http\Controllers\User;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;

class TimezoneController extends Controller
{
    public function __invoke(Request $request)
    {
        $user = Auth::user();

        $user->forceFill([
            'timezone' => $request->time_zone
        ])->save();

        Config::set('app.timezone', $user->timezone);
        date_default_timezone_set($user->timezone);

        return back();
    }
}
