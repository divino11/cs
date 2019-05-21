<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\TickerResource;
use App\Ticker;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CurrencyPriceController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @return TickerResource
     */
    public function __invoke(Request $request)
    {
        $ccxt = '\\ccxt\\' . $request->selectedPlatform;
        $exchange = new $ccxt;

        return $exchange->fetch_ticker($request->selectedCurrency);
    }
}
