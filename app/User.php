<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

/**
 * App\User
 *
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @mixin \Eloquent
 */
class User extends Authenticatable implements MustVerifyEmail
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'phone', 'notification_email', 'pushover', 'telegram'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

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

    public function hasPhoneVerified()
    {
        return (bool) isset($this->phone_verified_at);
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

    public function routeNotificationForMail()
    {
        return $this->notification_email_verified_at ? $this->notification_email : $this->email;
    }

    public function routeNotificationForNexmo()
    {
        return $this->phone_verified_at ? $this->phone : '';
    }
}
