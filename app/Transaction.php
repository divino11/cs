<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

/**
 * App\Transaction
 *
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Transaction newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Transaction newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Transaction query()
 * @mixin \Eloquent
 */
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
