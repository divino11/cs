<?php

namespace App;

use App\AlertStrategies\Percentage;
use App\AlertStrategies\PricePoint;
use App\AlertStrategies\RegularUpdate;
use App\Contracts\AlertStrategy;
use App\Enums\AlertType;
use Carbon\Carbon;
use Carbon\CarbonInterval;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Alert
 *
 * @property int $id
 * @property int $user_id
 * @property int|null $exchange_id
 * @property int $market_id
 * @property int $type
 * @property array $conditions
 * @property int $triggerings_number
 * @property int $triggerings_limit
 * @property string|null $triggered_at
 * @property int $enabled
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Exchange|null $exchange
 * @property-read mixed $interval
 * @property-read mixed $name
 * @property-read mixed $type_key
 * @property-read \App\Market $market
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\AlertNotificationChannel[] $notificationChannels
 * @property-read \App\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Alert enabled()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Alert newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Alert newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Alert query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Alert whereConditions($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Alert whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Alert whereEnabled($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Alert whereExchangeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Alert whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Alert whereMarketId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Alert whereTriggeredAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Alert whereTriggeringsLimit($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Alert whereTriggeringsNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Alert whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Alert whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Alert whereUserId($value)
 * @mixin \Eloquent
 */
class Alert extends Model
{
    protected $fillable = ['exchange_id', 'market_id', 'type', 'conditions', 'triggerings_limit', 'enabled'];

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
                    break;
                case AlertType::Regular_Update:
                    $this->strategy = new RegularUpdate();
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

    public function getIntervalAttribute()
    {
        return CarbonInterval::make($this->conditions['interval'])->forHumans();
    }

    public function getCooldownAttribute()
    {
        if ($this->type != AlertType::Price_Point) {
            return new CarbonInterval($this->conditions['interval']);
        }
        return new CarbonInterval(0,0,0,0,1);
    }

    public function scopeEnabled(Builder $query)
    {
            return $query
                ->whereColumn('triggerings_number', '<=', 'triggerings_limit')
                ->where('enabled', true)
                ->whereDate('triggered_at', '<=', Carbon::now()->sub($this->cooldown))
                ->orWhereNull('triggered_at');
    }

    public function getAvailableNotificationChannels()
    {
        $user = $this->user;

        return $this->notificationChannels->filter(function($value) use ($user){
            return $user->routeNotificationFor($value->notification_channel_name);
        });
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
