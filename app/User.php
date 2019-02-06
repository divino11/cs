<?php

namespace App;

use Hexters\CoinPayment\Entities\CoinPaymentuserRelation;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use NotificationChannels\Pushover\PushoverReceiver;
use Laravel\Cashier\Billable;

/**
 * App\User
 *
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @mixin \Eloquent
 */
class User extends Authenticatable implements MustVerifyEmail
{
    use Notifiable, Billable, CoinPaymentuserRelation;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'phone', 'sms', 'notification_email', 'pushover', 'telegram'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public static function updateSmsCount($id) {
        $user = User::find($id);
        if (isset($user->sms)) {
            $user->increment('sms', 100);
        } else {
            $user->sms = 100;
            $user->save();
        }
    }

    public function alerts()
    {
        return $this->hasMany(Alert::class);
    }

    public function getNotificationEmail()
    {
        return $this->hasNotificationEmail() ? $this->notification_email : $this->email;
    }

    private function hasNotificationEmail()
    {
        return isset($this->notification_email);
    }

    public function hasNotificationEmailVerified()
    {
        return (bool) ($this->hasNotificationEmail() ? $this->notification_email_verified_at : $this->email_verified_at);
    }

    public function hasTelegramVerified()
    {
        return (bool) isset($this->telegram_verified_at);
    }

    public function getNotificationPhone()
    {
        return $this->hasNotificationPhone() ? $this->notification_phone : $this->phone;
    }

    private function hasNotificationPhone()
    {
        return isset($this->notification_phone);
    }

    public function hasNotificationPhoneVerified()
    {
        return (bool) ($this->hasNotificationPhone() ? $this->phone_verified_at : $this->phone_verified_at);
    }

    private function hasNotificationTelegram()
    {
        return isset($this->notification_telegram);
    }

    public function hasNotificationTelegramVerified()
    {
        return (bool) ($this->hasNotificationTelegram() ? $this->telegram_verified_at : $this->telegram_verified_at);
    }

    public function hasPhoneVerified()
    {
        return (bool) isset($this->phone_verified_at);
    }

    public function getNotificationPushover()
    {
        return $this->hasNotificationPushover() ? $this->notification_pushover : $this->pushover;
    }

    private function hasNotificationPushover()
    {
        return isset($this->notification_pushover);
    }

    public function hasNotificationPushoverVerified()
    {
        return (bool) ($this->hasNotificationPushover() ? $this->pushover_verified_at : $this->pushover_verified_at);
    }

    public function hasPushoverVerified()
    {
        return (bool) isset($this->pushover_verified_at);
    }

    public function markEmailAsVerified()
    {
        parent::markEmailAsVerified();

        if ($this->email == $this->notification_email) {
            $this->markNotificationEmailAsVerified();
        }
    }

    public function markNotificationEmailAsVerified()
    {
        $this->forceFill([
            'notification_email_verified_at' => $this->freshTimestamp(),
        ])->save();
    }

    public function markNotificationPhoneAsVerified()
    {
        $this->forceFill([
            'phone_verified_at' => $this->freshTimestamp(),
        ])->save();
    }

    public function markNotificationTelegramAsVerified()
    {
        $this->forceFill([
            'telegram_verified_at' => $this->freshTimestamp(),
        ])->save();
    }

    public function markNotificationPushoverAsVerified()
    {
        $this->forceFill([
            'pushover_verified_at' => $this->freshTimestamp(),
        ])->save();
    }

    public function routeNotificationForMail()
    {
        return $this->notification_email_verified_at ? $this->notification_email : $this->email;
    }

    public function routeNotificationForNexmo()
    {
        return $this->phone_verified_at ? $this->phone : '';
    }

    public function routeNotificationForPushover()
    {
        return PushoverReceiver::withUserKey($this->pushover);
    }

    public function routeNotificationForTelegram()
    {
        return $this->telegram;
    }
}
