<?php

namespace App\Http\Controllers\Api\Payments;

use App\Enums\PaymentPrice;
use App\Http\Controllers\Controller;
use CoinPayment;
use Illuminate\Support\Facades\Auth;

class CoinPaymentSubscriptionController extends Controller
{
    public function __invoke()
    {
        /*
    *   @required true
    */
        $trx['amountTotal'] = PaymentPrice::Subscription; // USD
        $trx['note'] = 'Subscription Pro';

        /*
        *   @required true
        *   @example first item
        */
        $trx['items'][0] = [
            'descriptionItem' => 'Subscription Pro',
            'priceItem' => PaymentPrice::Subscription, // USD
            'qtyItem' => 1,
            'subtotalItem' => PaymentPrice::Subscription // USD
        ];

        $trx['payload'] = [
            // your custom array here
            'subscription' => 'subscription',
            'description' => 'Subscription Pro',
            'priceItem' => PaymentPrice::Subscription,
            'service' => 'blockchain',
            'user_id' => Auth::user()->id,
        ];

        $link_transaction = CoinPayment::url_payload($trx);

        return view('user.subscription.create', ['link_transaction' => $link_transaction]);
    }
}
