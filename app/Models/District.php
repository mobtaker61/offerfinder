<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class District extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'local_name',
        'latitude',
        'longitude',
        'boundary_coordinates',
        'description',
        'emirate_id',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'latitude' => 'float',
        'longitude' => 'float',
        'boundary_coordinates' => 'array'
    ];

    // Scope to find districts within a certain radius
    public function scopeWithinRadius($query, $latitude, $longitude, $radiusInKm)
    {
        return $query->whereRaw("
            (6371 * acos(cos(radians(?)) * cos(radians(latitude)) * 
            cos(radians(longitude) - radians(?)) + sin(radians(?)) * 
            sin(radians(latitude)))) <= ?
        ", [$latitude, $longitude, $latitude, $radiusInKm]);
    }

    // Scope to find districts containing a point
    public function scopeContainingPoint($query, $latitude, $longitude)
    {
        return $query->whereRaw("
            ST_Contains(
                ST_GeomFromGeoJSON(boundary_coordinates),
                ST_SRID(POINT(?, ?), 4326)
            )
        ", [$longitude, $latitude]);
    }

    // Relationship with Emirate
    public function emirate(): BelongsTo
    {
        return $this->belongsTo(Emirate::class);
    }

    // Relationship with Neighbours
    public function neighbours(): HasMany
    {
        return $this->hasMany(Neighbour::class);
    }
} 