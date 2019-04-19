<?php

namespace App\AlertStrategies;

use App\Alert;
use App\Contracts\AlertStrategy;
use App\Ticker;
use Carbon\Carbon;
use Carbon\CarbonInterval;
use Carbon\CarbonPeriod;

abstract class AbstractPercentage implements AlertStrategy
{
    protected $alertValue;

    protected $current;

    protected $previous;

    public function __construct(Alert $alert)
    {
        $this->alertValue = $alert->conditions['value'];
        $fromDate = Carbon::now()->sub(CarbonInterval::make($alert->conditions['interval']));
        $this->current = Ticker::marketLatest($alert->exchange_id, $alert->market_id)
            ->firstOrFail()
            ->getMetric($alert->conditions['metric']);
        $this->previous = Ticker::marketLatest($alert->exchange_id, $alert->market_id)
            ->whereDate('created_at', '<=', $fromDate)
            ->firstOrFail()
            ->getMetric($alert->conditions['metric']);
    }
}