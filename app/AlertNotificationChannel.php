<?php

namespace App;

use App\Enums\NotificationChannel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notification;

/**
 * App\AlertNotificationChannel
 *
 * @property int $id
 * @property int $alert_id
 * @property int $notification_channel
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property-read \App\Alert $alert
 * @property-read mixed $notification_channel_description
 * @property-read mixed $notification_channel_name
 * @method static \Illuminate\Database\Eloquent\Builder|\App\AlertNotificationChannel newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\AlertNotificationChannel newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\AlertNotificationChannel query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\AlertNotificationChannel whereAlertId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\AlertNotificationChannel whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\AlertNotificationChannel whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\AlertNotificationChannel whereNotificationChannel($value)
 * @mixin \Eloquent
 */
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
        return strtolower(NotificationChannel::getKey($this->notification_channel));
    }

    public function getNotificationChannelDescriptionAttribute() {
        return NotificationChannel::getDescription($this->notification_channel);
    }
}
