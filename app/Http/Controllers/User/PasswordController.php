<?php

namespace App\Http\Controllers\User;

use App\Http\Requests\User\ChangePasswordRequest;
use App\Notifications\UpdatePasswordSuccess;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class PasswordController extends Controller
{
    /**
     * Show the form for editing the specified resource.
     *
     */
    public function create()
    {
        $user = Auth::user();

        return view('user.changePassword', ['user' => $user]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(ChangePasswordRequest $request)
    {
        $request->user()->update([
            'password' => bcrypt($request->new_password),
        ]);

        $request->user()->notify(new UpdatePasswordSuccess($request->user()->email));

        return redirect()->route('user.account')->with('status', 'Password has been updated');
    }
}
