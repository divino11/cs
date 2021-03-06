<?php

namespace App\Http\Controllers\Api\Payments;

use App\Http\Requests\Subscriptions\CreateRequest;
use App\Transaction;
use Carbon\Carbon;
use App\Http\Controllers\Controller;

class SubscribeStripeController extends Controller
{
    public function __invoke(CreateRequest $request)
    {
        if ($request->stripeToken) {
            try {
                $request->user()->createAsStripeCustomer();
                if ($request->plan == 'yearly') {
                    $request->user()->newSubscription('main', config('payments.' . $request->plan . '.plan'))
                        ->create($request->stripeToken);
                } else {
                    $request->user()->newSubscription('main', config('payments.' . $request->plan . '.plan'))
                        ->trialDays(7)
                        ->create($request->stripeToken);
                }
            } catch (\Exception $e) {
                return redirect()->back()->withErrors([$e->getMessage()]);
            }

            Transaction::updateOrCreate(['created_at' => Carbon::now()], [
                'user_id' => $request->user()->id,
                'description' => 'Advanced plan',
                'amount' => config('payments.' . $request->plan . '.price'),
                'service' => config('payments.sms.service'),
                'status' => 100,
            ]);

            return redirect()->route('user.subscription.index')->with('status', 'You have purchased advanced subscription');
        } else {
            Transaction::updateOrCreate(['created_at' => Carbon::now()], [
                'user_id' => $request->user()->id,
                'description' => 'Advanced plan',
                'amount' => config('payments.' . $request->plan . '.price'),
                'service' => config('payments.sms.service'),
                'status' => -1,
            ]);
            return redirect()->route('user.subscription.index')->with('status', 'Data is invalid');
        }
    }
}
