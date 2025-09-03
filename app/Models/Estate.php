<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Estate extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'title',
        'image',
        'description',
        'price',
        'address',
        'location',
        'area',
        'listing_type',
        'rate',
        'rate_count',
        'closed_at',
        'estate_type',
        'status' ,
        'other_data' ,
    ];

    protected $casts = [
        'location' => 'json',
        'other_data' => 'json'
    ];

    /**
     * Get the user that owns the Estate
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * The raters that belong to the Estate
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function raters(): BelongsToMany
    {
        return $this->belongsToMany(User::class, EstateUserRate::class);
    }

    public function rates(): HasMany{
        return $this->hasMany(EstateUserRate::class);
    }
}
