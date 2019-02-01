<?php

namespace App\Http\Controllers\Api\Payments;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use CoinPayment;
use Illuminate\Support\Facades\Auth;

class CoinPaymentSmsController extends Controller
{
    public function __invoke()
    {
        /*
    *   @required true
    */
        $trx['amountTotal'] = 2; // USD
        $trx['note'] = '100 SMS Credits';

        /*
        *   @required true
        *   @example first item
        */
        $trx['items'][0] = [
            'descriptionItem' => '100 SMS Credits',
            'priceItem' => 2, // USD
            'qtyItem' => 1,
            'subtotalItem' => 2 // USD
        ];

        $trx['payload'] = [
            // your custom array here
            'sms' => 'sms',
            'description' => '100 Sms Credits',
            'priceItem' => '2',
            'service' => 'blockchain',
            'user_id' => Auth::user()->id,
        ];

        $link_transaction = CoinPayment::url_payload($trx);

        return view('user.sms_credits', ['link_transaction' => $link_transaction]);
    }
}
