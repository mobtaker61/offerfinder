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
        'address',
        'location',
        'working_hours',
        'customer_service',
        'emirate_id',
        'district_id',
        'market_id'
    ];

    protected $casts = [
        'latitude' => 'decimal:8',
        'longitude' => 'decimal:8',
        'is_active' => 'boolean'
    ];

    public function emirate()
    {
        return $this->belongsTo(Emirate::class);
    }

    public function district()
    {
        return $this->belongsTo(District::class);
    }

    public function market()
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
