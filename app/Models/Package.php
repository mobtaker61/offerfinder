<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Package extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * Get the feature types included in this package
     */
    public function featureTypes(): BelongsToMany
    {
        return $this->belongsToMany(FeatureType::class, 'package_features')
            ->withTimestamps();
    }

    /**
     * Get the plans based on this package
     */
    public function plans(): HasMany
    {
        return $this->hasMany(Plan::class);
    }
}
