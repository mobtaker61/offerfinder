<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Emirate extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'local_name',
        'latitude',
        'longitude',
        'boundary_coordinates',
        'is_active',
        'code',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'latitude' => 'float',
        'longitude' => 'float',
        'boundary_coordinates' => 'array'
    ];

    // Scope to find emirates within a certain radius
    public function scopeWithinRadius($query, $latitude, $longitude, $radiusInKm)
    {
        return $query->whereRaw("
            (6371 * acos(cos(radians(?)) * cos(radians(latitude)) * 
            cos(radians(longitude) - radians(?)) + sin(radians(?)) * 
            sin(radians(latitude)))) <= ?
        ", [$latitude, $longitude, $latitude, $radiusInKm]);
    }

    // Scope to find emirates containing a point
    public function scopeContainingPoint($query, $latitude, $longitude)
    {
        return $query->whereRaw("
            ST_Contains(
                ST_GeomFromGeoJSON(boundary_coordinates),
                ST_SRID(POINT(?, ?), 4326)
            )
        ", [$longitude, $latitude]);
    }

    // Relationship with Branches
    public function branches()
    {
        return $this->hasMany(Branch::class);
    }

    // Relationship with Districts
    public function districts(): HasMany
    {
        return $this->hasMany(District::class);
    }
}
