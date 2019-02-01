<?php

namespace App\Http\Controllers\Api\Payments;

use App\Http\Requests\Subscriptions\CreateRequest;
use App\Transaction;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class SubscribeBraintreeController extends Controller
{
    public function __invoke(CreateRequest $request)
    {
        if ($request->nonce) {
            $request->user()->subscriptions()->create([
                'name' => 'main',
                'braintree_id' => '1',
                'braintree_plan' => 'premium',
                'quantity' => '1'
            ]);
            Transaction::updateOrCreate(['transaction_date' => Carbon::now()], [
                'user_id' => $request->user()->id,
                'transaction_date' => Carbon::now(),
                'description' => 'Subscription Pro',
                'amount' => 100,
                'service' => $request->type,
                'status' => 100,
            ]);
            return ['success' => true];
        } else {
            Transaction::updateOrCreate(['transaction_date' => Carbon::now()], [
                'user_id' => $request->user()->id,
                'transaction_date' => Carbon::now(),
                'description' => 'Subscription Pro',
                'amount' => 100,
                'service' => $request->type,
                'status' => -1,
            ]);
            return ['success' => false];
        }
    }
}
