<?php

namespace App;

use App\Contracts\AlertCondition;
use App\Enums\AlertType;
use Illuminate\Database\Eloquent\Model;

class Alert extends Model
{
    protected $fillable = ['exchange_id', 'market_id', 'type', 'conditions', 'triggerings_limit'];

    protected $casts = ['conditions' => 'array'];

    private $conditionsInstance;

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

    public function getCondition() : AlertCondition
    {
        if (empty($this->conditionsInstance)) {
            $className = "\App\Alerts\\" . AlertType::getKey($this->type) . "Alert";
            $this->conditionsInstance = new $className($this);
        }

        return $this->conditionsInstance;
    }

    public function getDescriptionAttribute()
    {
        return $this->getCondition()->getDescription();
    }

    public function getTypeKeyAttribute()
    {
        return strtolower(AlertType::getKey($this->type));
    }

    public function getNameAttribute()
    {
        return strtoupper($this->exchange->name) . ' - ' . $this->market->base . '/' . $this->market->quote;
    }

    public function toggle()
    {
        $this->enabled = !$this->enabled;

        return $this;
    }
}
