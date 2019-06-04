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
            'amountTotal' => config('payments.sms.crypto'),
            'note' => '5000 SMS Credits',
            'items' => [
                [
                    'descriptionItem' => '5000 SMS Credits',
                    'priceItem' => config('payments.sms.crypto'), // USD
                    'qtyItem' => 1,
                    'subtotalItem' => config('payments.sms.crypto') // USD
                ]
            ],
            'payload' => [
                'sms' => 'sms',
                'description' => '5000 Sms Credits',
                'priceItem' => config('payments.sms.crypto'),
                'service' => 'blockchain',
                'user_id' => Auth::user()->id,
            ]
        ];

        $link_transaction = \CoinPayment::url_payload($trx);

        return view('user.sms_credits', [
            'link_transaction' => $link_transaction,
            'user' => Auth::user()
        ])->with('status', 'You have purchased 5000 SMS Credits');
    }
}
