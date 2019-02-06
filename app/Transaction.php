<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Transaction extends Model
{
    protected $fillable = [
        'user_id', 'description', 'amount', 'service', 'status'
    ];

    public function getStatusTransactionAttribute() {
        switch ($this->status) {
            case -1:
                return 'Canceled';
                break;
            case 100:
                return 'Complete';
                break;
        }
    }
}
