<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EstateUserRate extends Model
{
    protected $fillable = [
        'id',
        'user_id',
        'estate_id',
        'rate'
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }
}
