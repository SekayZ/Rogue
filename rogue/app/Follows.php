<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Follows extends Model
{
    protected $fillable = [
        'user_id', 'followed',
    ];


}
