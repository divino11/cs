<?php

namespace App\Jobs;

use App\Alert;
use App\AlertContext;
use App\Enums\AlertMetric;
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
        $this->ticker = Ticker::marketLatest($alert->exchange_id, $alert->market_id)->first();
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

        foreach ($this->alert->notificationChannels as $channel) {
            switch ($channel->notification_channel) {
                case '1':
                    $this->alert->user->notify(new AlertTriggered($this->alert, $this->ticker));
                    break;
                case '2':
                    Nexmo::message()->send([
                        'to' => $this->alert->user->phone,
                        'from' => 'CoinSpy',
                        'text' => view('alert.description.' . $this->alert->type, ['alert' => $this->alert])->render() . '. The ' . AlertMetric::getDescription((int)$this->alert->conditions['metric'])
                    ]);
            }
        }


        $this->alert->trigger();
    }
}
