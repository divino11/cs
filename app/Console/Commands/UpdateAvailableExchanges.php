<?php

namespace App\Console\Commands;

use App\Exchange;
use ccxt\Exchange as ccxt;
use Illuminate\Console\Command;

class UpdateAvailableExchanges extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'exchanges:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update available exchanges';

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
        foreach(ccxt::$exchanges as $exchange){
            Exchange::firstOrCreate(['name' =>  $exchange, 'enabled' => 0]);
        }
    }
}
