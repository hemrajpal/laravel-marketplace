<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\State;
use App\Models\Product;

class City extends Model
{
    protected $fillable = [
        'state_id',
        'name',
        'slug',
    ];

    public function state()
    {
        return $this->belongsTo(State::class);
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
