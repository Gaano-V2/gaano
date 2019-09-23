<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Walkin extends Model
{
    public $timestamps = false;

    protected $hidden = [
        'reservation_id',
    ];

}
