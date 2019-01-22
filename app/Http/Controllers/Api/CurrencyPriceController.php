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
        return new TickerResource(
            Ticker::where('exchange_id', $request->selectedPlatform)
                ->where('market_id', $request->selectedCurrency)
                ->latest()
                ->first()
        );
    }
}
