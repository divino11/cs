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
        return view('user.billing', [
            'transactions' => Transaction::where('user_id', Auth::user()->id)
                ->orderBy('created_at', 'desc')
                ->paginate(10)
        ]);
    }
}
