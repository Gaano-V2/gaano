<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model {

    protected $fillable = [
        'image',
        'brand',
        'name',
        'seats',
        'd_price',
        'w_price',
        'm_price',
        'gas',
        'transmission',
    ];

    protected $hidden = [
        'updated_at',
    ];

    public function on_reserve() {

        return $this->hasMany('App\Reservation');

    }

}
