<?php

namespace App\Jobs;

use App\Exchange;
use App\Market;
use App\Ticker;
use ccxt\NotSupported;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class FetchExchangeTickers implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var \ccxt\Exchange ccxt instance
     */
    private $ccxt;

    /**
     * @var Exchange
     */
    private $exchange;

    public function __construct(Exchange $exchange)
    {
        $this->exchange = $exchange;
        $class = '\\ccxt\\' . $exchange->name;
        $this->ccxt = new $class;
    }

    public function handle()
    {
        $ccxt = $this->ccxt;
        try {
            $tickers = $ccxt->fetchTickers();
        } catch (NotSupported $exception) {
            $tickers = collect($ccxt->fetchMarkets())->map(function($market) use ($ccxt) {
                return $ccxt->fetchTicker($market['symbol']);
            });
        }

        collect($tickers)->each([$this, 'saveTicker']);
    }

    public function saveTicker($ticker) {
        list($base, $quote) = explode('/', $ticker['symbol']);
        $market = Market::firstOrCreate(['base' => $base, 'quote' => $quote]);
        $this->exchange->markets()->syncWithoutDetaching([$market->id]);
        Ticker::create([
            'exchange_id'   => $this->exchange->id,
            'market_id'     => $market->id,
            'last'          => $ticker['last'],
            'volume'        => $ticker['baseVolume'],
        ]);
    }
}
