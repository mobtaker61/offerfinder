<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class FeatureType extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'key',
        'description',
        'value_type',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * Get the packages that include this feature type
     */
    public function packages(): BelongsToMany
    {
        return $this->belongsToMany(Package::class, 'package_features')
            ->withTimestamps();
    }

    /**
     * Get the plan feature values for this feature type
     */
    public function planFeatureValues(): HasMany
    {
        return $this->hasMany(PlanFeatureValue::class);
    }
}
