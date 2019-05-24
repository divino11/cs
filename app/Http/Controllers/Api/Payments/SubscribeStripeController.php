<?php

namespace App\Http\Controllers\Api\Payments;

use App\Enums\PaymentPrice;
use App\Http\Requests\Subscriptions\CreateRequest;
use App\Transaction;
use Carbon\Carbon;
use App\Http\Controllers\Controller;
use Stripe\Error\ApiConnection;
use Stripe\Error\Authentication;
use Stripe\Error\Base;
use Stripe\Error\Card;
use Stripe\Error\InvalidRequest;
use Stripe\Error\RateLimit;

class SubscribeStripeController extends Controller
{
    public function __invoke(CreateRequest $request)
    {
        if ($request->stripeToken) {

            try {
                $request->user()->createAsStripeCustomer();
                $request->user()->newSubscription('main', config('payments.subscriptions.plan'))
                    ->create($request->stripeToken);
            } catch (\Exception $e) {
                return redirect()->back()->withErrors([$e->getMessage()]);
            }

            Transaction::updateOrCreate(['created_at' => Carbon::now()], [
                'user_id' => $request->user()->id,
                'description' => 'Advanced plan',
                'amount' => config('payments.subscriptions.price'),
                'service' => config('payments.sms.service'),
                'status' => 100,
            ]);



            return redirect()->route('user.subscription.index')->with('status', 'You have purchased pro subscription');
        } else {
            Transaction::updateOrCreate(['created_at' => Carbon::now()], [
                'user_id' => $request->user()->id,
                'description' => 'Advanced plan',
                'amount' => config('payments.subscriptions.price'),
                'service' => config('payments.sms.service'),
                'status' => -1,
            ]);
            return redirect()->route('user.subscription.index')->with('status', 'Data is invalid');
        }
    }
}
