<?php

namespace App\Http\Controllers\User;

use App\Transaction;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ShowBillingController extends Controller
{
    public function __invoke()
    {
        //TODO: переделать на  $user->transactions()
        return view('user.billing', [
            'transactions' => Transaction::where('user_id', Auth::user()->id)
                ->latest()
                ->paginate(10)
        ]);
    }
}
