<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Transaction extends Model
{
    protected $fillable = [
        'user_id', 'transaction_date', 'description', 'amount', 'service', 'status'
    ];

    public function getCreatedAtAttribute($value)
    {
        if(Auth::user()) {
            $date = Carbon::createFromFormat('Y-m-d H:i:s', $value);
            $date->setTimezone(Auth::user()->timezone ?: "UTC");

            return $date->toDateTimeString();
        } else {
            return $value;
        }
    }
}
