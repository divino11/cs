<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Exchange
 *
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Market[] $markets
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Exchange enabled()
 * @mixin \Eloquent
 * @property int $id
 * @property string $name
 * @property int $enabled
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Exchange newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Exchange newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Exchange query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Exchange whereEnabled($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Exchange whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Exchange whereName($value)
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
