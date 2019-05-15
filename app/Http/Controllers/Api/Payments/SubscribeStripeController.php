<?php

namespace App\Http\Controllers\Api\Payments;

use App\Enums\PaymentPrice;
use App\Http\Requests\Subscriptions\CreateRequest;
use App\Transaction;
use Carbon\Carbon;
use App\Http\Controllers\Controller;

class SubscribeStripeController extends Controller
{
    public function __invoke(CreateRequest $request)
    {
        if ($request->stripeToken) {

            $request->user()->createAsStripeCustomer();
            $request->user()->newSubscription('main', 'plan_F4XhvQQuBs8VaZ')->create($request->stripeToken);

            Transaction::updateOrCreate(['created_at' => Carbon::now()], [
                'user_id' => $request->user()->id,
                'description' => 'Subscription Pro',
                'amount' => PaymentPrice::Subscription,
                'service' => 'CreditCard',
                'status' => 100,
            ]);
            return redirect()->route('user.subscription.index')->with('status', 'You have purchased pro subscription');
        } else {
            Transaction::updateOrCreate(['created_at' => Carbon::now()], [
                'user_id' => $request->user()->id,
                'description' => 'Subscription Pro',
                'amount' => PaymentPrice::Subscription,
                'service' => 'CreditCard',
                'status' => -1,
            ]);
            return redirect()->route('user.subscription.index')->with('status', 'Data is invalid');
        }
    }
}
