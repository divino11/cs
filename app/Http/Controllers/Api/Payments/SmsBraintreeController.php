<?php

namespace App\Http\Controllers\Api\Payments;

use App\Transaction;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class SmsBraintreeController extends Controller
{
    public function __invoke(Request $request)
    {
        if($request->nonce) {
            User::find($request->user()->id)
                ->increment('sms', 100);
            Transaction::updateOrCreate(['transaction_date' => Carbon::now()], [
                'user_id' => $request->user()->id,
                'transaction_date' => Carbon::now(),
                'description' => '100 SMS Credits',
                'amount' => 2,
                'service' => $request->type,
                'status' => 100,
            ]);
            return ['success' => true];
        } else {
            Transaction::updateOrCreate(['transaction_date' => Carbon::now()], [
                'user_id' => $request->user()->id,
                'transaction_date' => Carbon::now(),
                'description' => '100 SMS Credits',
                'amount' => 2,
                'service' => $request->type,
                'status' => '-1',
            ]);
            return ['success' => false];
        }
    }
}
