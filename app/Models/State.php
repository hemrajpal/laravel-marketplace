<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use App\Models\City;
use App\Models\Product;

class State extends Model
{
    protected $fillable = [
        'name',
        'slug',
    ];

    public function cities()
    {
        return $this->hasMany(City::class);
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
