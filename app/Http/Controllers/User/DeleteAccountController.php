<?php

namespace App\Http\Controllers\User;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DeleteAccountController extends Controller
{
    public function __invoke(Request $request)
    {
        $user = User::find($request->user_id);
        $user->delete();

        return redirect()->route('login')->with('status', 'Account was removed success');
    }
}
