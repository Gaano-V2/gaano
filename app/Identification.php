<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Identification extends Model {

    public $timestamps = false;

    protected $fillable = [
        'government_id', 'license',
    ];

    protected $hidden = [
        'id', 'user_id',
    ];

}
