<?php

namespace App;

use App\Enums\AlertMetric;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

/**
 * App\Ticker
 *
 * @mixin \Illuminate\Database\Eloquent\
 * @property int $id
 * @property int $exchange_id
 * @property int $market_id
 * @property float|null $bid
 * @property float|null $ask
 * @property float|null $volume
 * @property \Illuminate\Support\Carbon $created_at
 * @property-read mixed $high_price
 * @property-read mixed $low_price
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Ticker daily()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Ticker marketLatest($exchangeId, $marketId)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Ticker newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Ticker newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Ticker query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Ticker whereAsk($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Ticker whereBid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Ticker whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Ticker whereExchangeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Ticker whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Ticker whereMarketId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Ticker whereVolume($value)
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
        return $query->where('exchange_id', $exchangeId)->where('market_id', $marketId)->latest();
    }

    public function getMetric($metric)
    {
        switch($metric) {
            case AlertMetric::Price:
                return $this->bid;
            /*case AlertMetric::Sell_price:
                return $this->ask;
            case AlertMetric::High_price:
                return $this->high_price;
            case AlertMetric::Low_price:
                return $this->low_price;*/
            case AlertMetric::Volume:
                return $this->volume;
        }
        throw new \Exception();
    }
}