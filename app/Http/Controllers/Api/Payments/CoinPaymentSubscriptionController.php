<?php

namespace App\Http\Controllers\Api\Payments;

use App\User;
use Illuminate\Http\Request;
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
        $trx['amountTotal'] = 100; // USD
        $trx['note'] = 'Subscription Pro';

        /*
        *   @required true
        *   @example first item
        */
        $trx['items'][0] = [
            'descriptionItem' => 'Subscription Pro',
            'priceItem' => 100, // USD
            'qtyItem' => 1,
            'subtotalItem' => 100 // USD
        ];

        $trx['payload'] = [
            // your custom array here
            'subscription' => 'subscription',
            'description' => 'Subscription Pro',
            'priceItem' => '100',
            'service' => 'blockchain',
            'user_id' => Auth::user()->id,
        ];

        $link_transaction = CoinPayment::url_payload($trx);

        return view('user.subscription.create', ['link_transaction' => $link_transaction]);
    }
}
