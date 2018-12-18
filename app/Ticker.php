<?php

namespace App;

use App\Enums\AlertMetric;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

/**
 * App\Ticker
 *
 * @mixin \Eloquent
 */
class Ticker extends Model
{
    const UPDATED_AT = null;

    const CREATED_AT = 'created_at';

    protected $guarded = ['id'];

    public function scopeDaily(Builder $query)
    {
        return $query->where('market_id', $this->market_id)->where('exchange_id', $this->exchange_id)->whereDate('created_at', $this->created_at->toDateString());
    }

    public function getHighPriceAttribute()
    {
        return $this->daily()->max('bid');
    }

    public function getLowPriceAttribute()
    {
        return $this->daily()->min('bid');
    }

    public function scopeMarketLatest(Builder $query, $exchangeId, $marketId)
    {
        return $query->where('exchange_id', $exchangeId)->where('market_id', $marketId)->latest()->first();
    }

    public function getMetric($metric)
    {
        switch($metric) {
            case AlertMetric::Buy_price:
                return $this->bid;
            case AlertMetric::Sell_price:
                return $this->ask;
            case AlertMetric::High_price:
                return $this->high_price;
            case AlertMetric::Low_price:
                return $this->low_price;
            case AlertMetric::Volume:
                return $this->volume;
        }
        throw new \Exception();
    }
}