<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Branch extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'market_id',
        'address',
        'latitude',
        'longitude',
        'is_active'
    ];

    protected $casts = [
        'latitude' => 'decimal:8',
        'longitude' => 'decimal:8',
        'is_active' => 'boolean'
    ];

    public function market(): BelongsTo
    {
        return $this->belongsTo(Market::class);
    }

    public function neighbours(): BelongsToMany
    {
        return $this->belongsToMany(Neighbour::class, 'branch_neighbour')
            ->withTimestamps();
    }

    public function offers(): BelongsToMany
    {
        return $this->belongsToMany(Offer::class, 'offer_branch')
            ->withTimestamps();
    }

    public function contactProfiles(): HasMany
    {
        return $this->hasMany(BranchContactProfile::class);
    }
}
