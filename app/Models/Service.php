<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    protected $fillable = [
        'name',
        'price',
    ];

    public function users() {
        return $this->belongsToMany(User::class,UserEstateService::class);
    }

    
    public function estates() {
        return $this->belongsToMany(Estate::class,UserEstateService::class);
    }
}
