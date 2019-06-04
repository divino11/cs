<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;

class OauthEmailController extends Controller
{
    protected $redirectTo = '/oauth-email';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('email')->except('logout');
    }

    public function __invoke()
    {
        return view('auth.oauth_email');
    }
}
