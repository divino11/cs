<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ShowSmsCreditsController extends Controller
{
    public function __invoke()
    {
        return view('user.sms_credits');
    }
}
