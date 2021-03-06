<?php

namespace App\Http\Controllers\Api;

use App\Ticker;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class LatestTickerController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        return Ticker::where('exchange_id', $request->exchange_id)
            ->where('market_id', $request->market_id)
            ->latest()
            ->first();
    }
}
