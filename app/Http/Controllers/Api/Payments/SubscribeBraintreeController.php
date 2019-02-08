<?php

namespace App\Http\Controllers\Api\Payments;

use App\Enums\PaymentPrice;
use App\Http\Requests\Subscriptions\CreateRequest;
use App\Transaction;
use Carbon\Carbon;
use App\Http\Controllers\Controller;

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
            Transaction::updateOrCreate(['created_at' => Carbon::now()], [
                'user_id' => $request->user()->id,
                'description' => 'Subscription Pro',
                'amount' => PaymentPrice::Subscription,
                'service' => $request->type,
                'status' => 100,
            ]);
            return ['success' => true];
        } else {
            Transaction::updateOrCreate(['created_at' => Carbon::now()], [
                'user_id' => $request->user()->id,
                'description' => 'Subscription Pro',
                'amount' => PaymentPrice::Subscription,
                'service' => $request->type,
                'status' => -1,
            ]);
            return ['success' => false];
        }
    }
}
