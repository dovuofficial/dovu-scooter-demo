<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DovuToken extends Model
{

    /**
    * Indicates if the model should be timestamped.
    *
    * @var bool
    */
    public $timestamps = true;

    public $fillable = [
        'user_id',
        'token',
    ];
}
