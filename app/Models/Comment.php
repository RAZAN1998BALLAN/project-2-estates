<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $fillable = [
        'id',
        'comment_id',
        'user_id',
        'estate_id',
        'comment'
    ];


    public function user(){
        return $this->belongsTo(User::class);
    }


    
}
