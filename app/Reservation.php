<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Reservation extends Model {

    protected $fillable = [
        'vehicle_id', 'start_date', 'end_date', 'time', 'status', 'message', 'total', 'is_walkin',
    ];

    protected $hidden = [
        'user_id',
    ];

    public function customer_walkin() {

        return $this->hasOne('App\Walkin');

    }

    public function user_reserve() {

        return $this->belongsTo('App\User', 'user_id')->with('profile', 'identification');

    }

    public function vehicle_reserve() {

        return $this->belongsTo('App\Vehicle', 'vehicle_id');

    }

}
