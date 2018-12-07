<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Exchange
 *
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Market[] $markets
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Exchange enabled()
 * @mixin \Eloquent
 */
class Exchange extends Model
{
    public $timestamps = false;

    public $fillable = ['name', 'enabled'];

    protected $attributes = [
        'enabled'   =>  0
    ];

    public function scopeEnabled($query)
    {
        return $query->where('enabled', 1);
    }

    public function markets()
    {
        return $this->belongsToMany(Market::class);
    }
}
