<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class OauthEmailController extends Controller
{
    public function __invoke(Request $request)
    {
        Auth::user()->fill([
            'email' => $request->email,
        ])->save();

        return back()->with('status', 'Email has been created');
    }
}
