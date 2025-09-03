<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EstateUserFavorite extends Model
{
    protected $fillable = [
        'id',
        'user_id',
        'estate_id',
    ];
}
