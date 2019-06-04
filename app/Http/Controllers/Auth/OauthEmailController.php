<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Request;

class OauthEmailController extends Controller
{
    public function __invoke(Request $request)
    {
        $request->user()->fill([
            'email' => $request->email,
        ])->save();

        return back()->with('status', 'Email has been crated');
    }
}
