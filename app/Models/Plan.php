<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Plan extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'package_id',
        'monthly_price',
        'yearly_price',
        'is_active',
    ];

    protected $casts = [
        'monthly_price' => 'decimal:2',
        'yearly_price' => 'decimal:2',
        'is_active' => 'boolean',
    ];

    /**
     * Get the package this plan is based on
     */
    public function package(): BelongsTo
    {
        return $this->belongsTo(Package::class);
    }

    /**
     * Get the feature values for this plan
     */
    public function featureValues(): HasMany
    {
        return $this->hasMany(PlanFeatureValue::class);
    }

    /**
     * Get the markets subscribed to this plan
     */
    public function markets(): HasMany
    {
        return $this->hasMany(Market::class);
    }

    /**
     * Get all feature types from the underlying package
     */
    public function getFeatureTypes()
    {
        return $this->package->featureTypes;
    }

    /**
     * Get a specific feature value
     */
    public function getFeatureValue(string $featureKey)
    {
        $featureType = FeatureType::where('key', $featureKey)->first();
        
        if (!$featureType) {
            return null;
        }
        
        return $this->featureValues()
            ->where('feature_type_id', $featureType->id)
            ->first()?->value;
    }
}
