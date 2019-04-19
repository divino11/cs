<?php

namespace App\Jobs;

use App\Alert;
use App\AlertContext;
use App\Enums\AlertMetric;
use App\Events\AlertNotification;
use App\Notifications\AlertTriggered;
use App\Ticker;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Nexmo\Laravel\Facade\Nexmo;

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
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        if (!$this->alert->match()) {
            return;
        }

        $this->alert->user->notify(new AlertTriggered($this->alert, $this->ticker));

        broadcast(new AlertNotification(
            $this->alert->user,
            $this->alert->name,
            AlertMetric::getDescription((int)$this->alert->conditions['metric']),
            $this->ticker->getMetric($this->alert->conditions['metric'])
        ));

        $this->alert->trigger();
    }
}
