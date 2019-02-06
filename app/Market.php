<?php

namespace App;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Market
 *
 * @property-read \App\Currency $baseCurrency
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Exchange[] $exchanges
 * @property-read mixed $symbol
 * @property-read \App\Currency $quoteCurrency
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Market enabled()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Market whereExchangesIn($exchanges)
 * @mixin \Eloquent
 * @property int $id
 * @property string $base
 * @property string $quote
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Market newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Market newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Market query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Market whereBase($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Market whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Market whereQuote($value)
 */
class Market extends Model
{
    protected $fillable = ['base', 'quote'];

    public $timestamps = false;

    public function getSymbolAttribute()
    {
        return "$this->base/$this->quote";
    }

    public function baseCurrency()
    {
        return $this->hasOne(Currency::class, 'ticker', 'base');
    }

    public function quoteCurrency()
    {
        return $this->hasOne(Currency::class, 'ticker', 'quote');
    }

    public function exchanges()
    {
        return $this->belongsToMany(Exchange::class);
    }

    public function scopeEnabled(Builder $query)
    {
        return $query->whereHas('exchanges', function ($query) {
            return $query->where('enabled', 1);
        })->distinct();
    }

    public function scopeWhereExchangesIn(Builder $query, $exchanges)
    {
        return $query->whereHas('exchanges', function (Builder $query) use ($exchanges) {
            return $query->enabled()->whereIn('exchanges.id', $exchanges);
        });
    }
}
