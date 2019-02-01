<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $fillable = [
        'user_id', 'transaction_date', 'description', 'amount', 'service', 'status'
    ];
}
