<?php

namespace App\Http\Controllers\Api\Payments;

use App\Enums\PaymentPrice;
use App\Transaction;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SmsStripeController extends Controller
{
    public function __invoke(Request $request)
    {
        if($request->stripeToken) {
             if (!$request->user()->stripe_id) {
                $request->user()->createAsStripeCustomer();
             }
            \Stripe\Stripe::setApiKey(config('services.stripe.secret'));

            \Stripe\Charge::create([
                "amount" => 200,
                "currency" => "usd",
                "source" => "tok_mastercard",
            ]);

            User::updateSmsCount($request->user()->id);
            Transaction::updateOrCreate(['created_at' => Carbon::now()], [
                'user_id' => $request->user()->id,
                'description' => '100 SMS Credits',
                'amount' => PaymentPrice::Sms,
                'service' => 'CreditCard',
                'status' => 100,
            ]);

            return redirect()->route('user.sms_credits')->with('status', 'You have purchased 100 SMS Credits');
        } else {
            Transaction::updateOrCreate(['created_at' => Carbon::now()], [
                'user_id' => $request->user()->id,
                'description' => '100 SMS Credits',
                'amount' => PaymentPrice::Sms,
                'service' => 'CreditCard',
                'status' => '-1',
            ]);
            return redirect()->route('user.sms_credits')->with('status', 'Data is invalid');
        }
    }
}
