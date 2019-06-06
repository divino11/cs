<?php

namespace App\AlertStrategies;

use App\Alert;
use App\Contracts\AlertStrategy;
use App\Ticker;
use Carbon\Carbon;
use Carbon\CarbonInterval;
use Carbon\CarbonPeriod;

abstract class AbstractChange implements AlertStrategy
{
    protected $alertValue;

    protected $current;

    protected $previous;

    public function __construct(Alert $alert)
    {
        foreach ($alert->conditions['values'] as $key => $value) {
            if ($alert->type == $key) {
                $this->alertValue = $value;
            }
        }
        $fromDate = Carbon::now()->sub(CarbonInterval::make($alert->interval_format));
        $this->current = Ticker::marketLatest($alert->exchange_id, $alert->market_id)
            ->firstOrFail()
            ->getMetric($alert->conditions['metric']);
        $this->previous = Ticker::marketLatest($alert->exchange_id, $alert->market_id)
            ->where('created_at', '<=', $fromDate)
            ->firstOrFail()
            ->getMetric($alert->conditions['metric']);
    }
}