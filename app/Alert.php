<?php

namespace App;

use App\AlertStrategies\Percentage;
use App\AlertStrategies\PricePoint;
use App\Contracts\AlertStrategy;
use App\Enums\AlertType;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Alert extends Model
{
    protected $fillable = ['exchange_id', 'market_id', 'type', 'conditions', 'triggerings_limit'];

    protected $casts = ['conditions' => 'array'];

    /** @var AlertStrategy */
    private $strategy;

    public function exchange()
    {
        return $this->belongsTo(Exchange::class);
    }

    public function market()
    {
        return $this->belongsTo(Market::class);
    }

    public function notificationChannels()
    {
        return $this->hasMany(AlertNotificationChannel::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    private function getStrategy() : AlertStrategy
    {
        if (empty($this->strategy)) {
            switch($this->type){
                case AlertType::Price_Point:
                    $this->strategy = new PricePoint();
                    break;
                case AlertType::Percentage:
                    $this->strategy = new Percentage();
            }
        }

        return $this->strategy;
    }

    public function match(Ticker $ticker) : bool
    {
        return $this->getStrategy()->process($this, $ticker);
    }

    public function getTypeKeyAttribute()
    {
        return strtolower(AlertType::getKey($this->type));
    }

    public function getNameAttribute()
    {
        return strtoupper($this->exchange->name) . ' - ' . $this->market->base . '/' . $this->market->quote;
    }

    public function scopeEnabled(Builder $query)
    {
        return $query->whereColumn('triggerings_number', '<', 'triggerings_limit')->where('enabled', true);
    }

    public function toggle()
    {
        $this->enabled = !$this->enabled;

        return $this;
    }

    public function trigger()
    {
        $this->triggered_at = Carbon::now();
        $this->triggerings_number++;
        $this->save();
    }
}
