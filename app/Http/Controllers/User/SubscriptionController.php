<?php

namespace App\Http\Controllers\User;

use App\Enums\PaymentPrice;
use App\Http\Requests\Subscriptions\CancelRequest;
use App\Http\Requests\Subscriptions\CreateRequest;
use App\Http\Requests\Subscriptions\ResumeRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use CoinPayment;

class SubscriptionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('user.subscription.index', ['user' => Auth::user()]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(CreateRequest $request)
    {
        $trx_yearly = [
            'amountTotal' => config('payments.yearly.price'),
            'note' => 'Advanced plan',
            'items' => [
                [
                    'descriptionItem' => 'Advanced plan',
                    'priceItem' => config('payments.yearly.price'),
                    'qtyItem' => 1,
                    'subtotalItem' => config('payments.yearly.price')
                ]
            ],
            'payload' => [
                'subscription' => 'subscription',
                'description' => 'Advanced plan',
                'plan' => 'yearly',
                'priceItem' => config('payments.yearly.price'),
                'service' => 'blockchain',
                'user_id' => Auth::user()->id,
            ]
        ];

        $trx_monthly = [
            'amountTotal' => config('payments.monthly.price'),
            'note' => 'Advanced plan',
            'items' => [
                [
                    'descriptionItem' => 'Advanced plan',
                    'priceItem' => config('payments.monthly.price'),
                    'qtyItem' => 1,
                    'subtotalItem' => config('payments.monthly.price')
                ]
            ],
            'payload' => [
                'subscription' => 'subscription',
                'description' => 'Advanced plan',
                'plan' => 'monthly',
                'priceItem' => config('payments.monthly.price'),
                'service' => 'blockchain',
                'user_id' => Auth::user()->id,
            ]
        ];

        $link_transaction_yearly = CoinPayment::url_payload($trx_yearly);
        $link_transaction_monthly = CoinPayment::url_payload($trx_monthly);

        return view('user.subscription.create', [
            'link_transaction_yearly' => $link_transaction_yearly,
            'link_transaction_monthly' => $link_transaction_monthly,
        ])->with('status', 'You have purchased pro subscription');
    }

    public function update(ResumeRequest $request)
    {
        $request->user()->subscriptions()->update([
            'ends_at' => null
        ]);

        return redirect()->back()->with('status', 'Your subscription has been restored');
    }

    public function destroy(CancelRequest $request)
    {
        if($request->user()->subscription('main')->stripe_id != 1) {
            $request->user()->subscription('main')->cancelNow();
        } else {
            $request->user()->subscriptions()->update([
                'ends_at' => now()->subDay()
            ]);
        }

        return redirect()->route('user.subscription.index')->with('status', 'Your subscription has been canceled');
    }

}
