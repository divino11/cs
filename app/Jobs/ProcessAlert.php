<?php

namespace App\Jobs;

use App\Alert;
use App\AlertContext;
use App\Notifications\AlertTriggered;
use App\Ticker;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class ProcessAlert implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var Alert
     */
    private $alert;

    /**
     * @var Ticker
     */
    private $ticker;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Alert $alert)
    {
        $this->alert = $alert;
        $this->ticker = Ticker::marketLatest($alert->exchange_id, $alert->market_id);
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        if (!$this->alert->match($this->ticker)) {
            return;
        }

        $this->alert->user->notify(new AlertTriggered($this->alert, $this->ticker));
        $this->alert->trigger();
    }
}
