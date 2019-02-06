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
            User::updateSmsCount($request->user()->id);
            Transaction::updateOrCreate(['created_at' => Carbon::now()], [
                'user_id' => $request->user()->id,
                'description' => '100 SMS Credits',
                'amount' => 2,
                'service' => $request->type,
                'status' => 100,
            ]);
            return ['success' => true];
        } else {
            Transaction::updateOrCreate(['created_at' => Carbon::now()], [
                'user_id' => $request->user()->id,
                'description' => '100 SMS Credits',
                'amount' => 2,
                'service' => $request->type,
                'status' => '-1',
            ]);
            return ['success' => false];
        }
    }
}
