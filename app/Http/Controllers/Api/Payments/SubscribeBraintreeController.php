<?php

namespace App\Http\Controllers\Api\Payments;

use App\Http\Requests\Subscriptions\CreateRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class SubscribeBraintreeController extends Controller
{
    public function __invoke(CreateRequest $request)
    {
        try {
            $request->user()->newSubscription('main', 'premium')->create($request->nonce);
            return ['success' => true];
        } catch (\Exception $e) {
            return ['success' => false];
        }
    }
}
