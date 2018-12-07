<?php

namespace App;

use App\Enums\NotificationChannel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notification;

class AlertNotificationChannel extends Model
{
    protected $fillable = ['notification_channel', 'created_at'];

    const UPDATED_AT = null;

    const CREATED_AT = 'created_at';

    public function alert()
    {
        return $this->belongsTo(Alert::class);
    }

    public function getNotificationChannelNameAttribute()
    {
        return NotificationChannel::getKey($this->notification_channel);
    }
}
