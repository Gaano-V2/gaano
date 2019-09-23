<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model {

    public $timestamps = false;

    protected $fillable = [
        'avatar', 'fname', 'mname', 'lname', 'gender', 'bday', 'phone',
    ];

    protected $hidden = [
        'id', 'user_id',
    ];

}
