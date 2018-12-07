<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder;

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
}