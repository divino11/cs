<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\CreateEmailRequest;
use Illuminate\Support\Facades\Auth;

class OauthEmailController extends Controller
{
    public function __invoke(CreateEmailRequest $request)
    {
        Auth::user()->fill([
            'email' => $request->email,
        ])->save();

        return back()->with('status', 'Email has been created');
    }
}
