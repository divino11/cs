<?php

namespace App\Console\Commands;

use App\Ticker;
use Illuminate\Console\Command;

class ClearTickers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tickers:clear';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clear tickers pair';

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
        return Ticker::truncate();
    }
}
