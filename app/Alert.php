<?php

namespace App;

use App\AlertStrategies\Crossing;
use App\AlertStrategies\CrossingDown;
use App\AlertStrategies\CrossingUp;
use App\AlertStrategies\FallsBy;
use App\AlertStrategies\GreaterThan;
use App\AlertStrategies\IncreasedBy;
use App\AlertStrategies\LessThan;
use App\AlertStrategies\Percentage;
use App\AlertStrategies\AbstractRegularUpdate;
use App\AlertStrategies\AbstractVolume;
use App\AlertStrategies\RegularUpdate;
use App\AlertStrategies\VolumeGreaterThan;
use App\AlertStrategies\VolumeLessThan;
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
    protected $fillable = ['exchange_id', 'market_id', 'type', 'conditions', 'alert_message', 'open_ended', 'frequency', 'interval_number', 'interval_unit', 'expiration_date', 'enabled'];

    protected $casts = ['conditions' => 'array'];

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

    private function getStrategy()
    {
        switch($this->type){
            case AlertType::Crossing:
                return new Crossing($this);
            case AlertType::Crossing_Up:
                return new CrossingUp($this);
            case AlertType::Crossing_Down:
                return new CrossingDown($this);
            case AlertType::Greater_Than:
                return new GreaterThan($this);
            case AlertType::Less_Than:
                return new LessThan($this);
            case AlertType::Increased_By:
                return new IncreasedBy($this);
            case AlertType::Falls_By:
                return new FallsBy($this);
            case AlertType::Regular_Update:
                return new RegularUpdate($this);
        }
    }

    public function match() : bool
    {
        return $this->getStrategy()->process();
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
        if ($this->conditions['cooldown_number']) {
            return CarbonInterval::fromString($this->conditions['cooldown_number'] . ' ' . $this->conditions['cooldown_unit']);
        }
        return new CarbonInterval('0', '0', '0', '0', '1');
    }

    public function scopeEnabled(Builder $query)
    {
        return $query
            ->where('enabled', true)
            ->where(function(Builder $query){
                $query->whereDate('triggered_at', '<=', Carbon::now()->sub($this->cooldown))->orWhereNull('triggered_at');
            })
            ->where(function(Builder $query){
                $query->whereDate('expiration_date', '>', Carbon::now());
            });
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
        if ($this->frequency == 0) {
            $this->enabled = 0;
        }
        $this->triggered_at = Carbon::now();
        $this->triggerings_number++;
        $this->save();
    }
}
