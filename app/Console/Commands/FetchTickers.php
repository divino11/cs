<?php

namespace App\Console\Commands;

use App\Exchange;
use App\Jobs\FetchExchangeTickers;
use Illuminate\Console\Command;

class FetchTickers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tickers:fetch';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fetch currency pairs';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        Exchange::enabled()->get()->each(function($exchange) {
            FetchExchangeTickers::dispatch($exchange);
        });
    }
}
