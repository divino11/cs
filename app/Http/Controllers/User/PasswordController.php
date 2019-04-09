<?php

namespace App\Http\Controllers\User;

use App\Http\Requests\User\ChangePasswordRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PasswordController extends Controller
{
    /**
     * Show the form for editing the specified resource.
     *
     */
    public function index()
    {
        return view('user.changePassword');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function update(ChangePasswordRequest $request)
    {
        $request->user()->fill([
            'password' => bcrypt($request->new_password),
        ])->save();

        return redirect()->route('user.account')->with('status', 'Password has been updated');
    }
}
