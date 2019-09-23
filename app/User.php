<?php

namespace App;

use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements JWTSubject, MustVerifyEmail {

    use Notifiable;

    protected $fillable = [
        'email', 'password',
    ];

    protected $hidden = [
        'password', 'remember_token', 'updated_at',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function getJWTIdentifier() {

        return $this->getKey();

    }

    public function getJWTCustomClaims() {

        return [];

    }

    public function profile() {

        return $this->hasOne('App\Profile');

    }

    public function identification() {

        return $this->hasOne('App\Identification');

    }

    public function has_reservation() {

        return $this->hasMany('App\Reservation')->with('vehicle_reserve');

    }

}
