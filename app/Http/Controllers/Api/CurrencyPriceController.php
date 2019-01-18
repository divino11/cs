<?php

namespace App\Http\Controllers\Api;

use App\Ticker;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CurrencyPriceController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        if ($request->selectedMetric != '2' && $request->selectedMetric != '3') {
            return Ticker::where('exchange_id', $request->selectedPlatform)
                ->where('market_id', $request->selectedCurrency)
                ->select($this->getMetric($request->selectedMetric))
                ->pluck($this->getMetric($request->selectedMetric))
                ->first();
        }
        if ($request->selectedMetric == '2') {
            return Ticker::where('exchange_id', $request->selectedPlatform)
                ->where('market_id', $request->selectedCurrency)
                ->latest()
                ->max('bid');
        }
        if ($request->selectedMetric == '3') {
            return Ticker::where('exchange_id', $request->selectedPlatform)
                ->where('market_id', $request->selectedCurrency)
                ->latest()
                ->min('bid');
        }
    }

    private function getMetric($metric = 0)
    {
        switch ($metric) {
            case 0:
                return 'bid';
            case 1:
                return 'ask';
            case 4:
                return 'volume';
        }
    }
}
