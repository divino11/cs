<?php

namespace App\Http\Controllers\User;

use App\Enums\PaymentPrice;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use CoinPayment;

class ShowSmsCreditsController extends Controller
{
    public function __invoke()
    {
        $trx = [
            'amountTotal' => PaymentPrice::Sms,
            'note' => '100 SMS Credits',
            'items' => [
                [
                    'descriptionItem' => '100 SMS Credits',
                    'priceItem' => PaymentPrice::Sms, // USD
                    'qtyItem' => 1,
                    'subtotalItem' => PaymentPrice::Sms // USD
                ]
            ],
            'payload' => [
                'sms' => 'sms',
                'description' => '100 Sms Credits',
                'priceItem' => PaymentPrice::Sms,
                'service' => 'blockchain',
                'user_id' => Auth::user()->id,
            ]
        ];

        $link_transaction = \CoinPayment::url_payload($trx);

        return view('user.sms_credits', ['link_transaction' => $link_transaction]);
    }
}
