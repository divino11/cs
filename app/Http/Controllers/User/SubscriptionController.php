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
        $trx = [
            'amountTotal' => PaymentPrice::Subscription,
            'note' => 'Subscription Pro',
            'items' => [
                [
                    'descriptionItem' => 'Subscription Pro',
                    'priceItem' => PaymentPrice::Subscription, // USD
                    'qtyItem' => 1,
                    'subtotalItem' => PaymentPrice::Subscription // USD
                ]
            ],
            'payload' => [
                'subscription' => 'subscription',
                'description' => 'Subscription Pro',
                'priceItem' => PaymentPrice::Subscription,
                'service' => 'blockchain',
                'user_id' => Auth::user()->id,
            ]
        ];

        $link_transaction = CoinPayment::url_payload($trx);

        return view('user.subscription.create', ['link_transaction' => $link_transaction])->with('status', 'You have purchased pro subscription');
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
        if($request->user()->subscription('main')->braintree_id != 1) {
            $request->user()->subscription('main')->cancelNow();
        } else {
            $request->user()->subscriptions()->update([
                'ends_at' => now()->subDay()
            ]);
        }

        return redirect()->route('user.subscription.index')->with('status', 'Your subscription has been canceled');
    }

}
