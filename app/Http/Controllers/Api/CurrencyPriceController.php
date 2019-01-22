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
    public function metricPrice(Request $request)
    {
        return Ticker::where('exchange_id', $request->selectedPlatform)
            ->where('market_id', $request->selectedCurrency)
            ->select($this->getMetric($request->selectedMetric))
            ->pluck($this->getMetric($request->selectedMetric))
            ->first();
    }

    public function highPrice(Ticker $ticker)
    {
        return $ticker->high_price;
    }

    public function lowPrice(Ticker $ticker)
    {
        return $ticker->low_price;
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
