<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserFavorite extends Model
{
    protected $fillable = [
        'user_id',
        'favoriteable_type',
        'favoriteable_id'
    ];

    /**
     * Get the user that owns the favorite
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the parent favoriteable model (offer, market, or branch)
     */
    public function favoriteable(): MorphTo
    {
        return $this->morphTo();
    }
} 