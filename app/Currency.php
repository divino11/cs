<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Currency
 *
 * @mixin \Eloquent
 */
class Currency extends Model
{
    protected $fillable = ['ticker', 'name'];

    public $timestamps = false;
}
