<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PlanFeatureValue extends Model
{
    use HasFactory;

    protected $fillable = [
        'plan_id',
        'feature_type_id',
        'value',
    ];

    /**
     * Get the plan that owns this feature value
     */
    public function plan(): BelongsTo
    {
        return $this->belongsTo(Plan::class);
    }

    /**
     * Get the feature type for this value
     */
    public function featureType(): BelongsTo
    {
        return $this->belongsTo(FeatureType::class);
    }

    /**
     * Get the typed value based on the feature type's value_type
     */
    public function getTypedValueAttribute()
    {
        $valueType = $this->featureType->value_type;
        
        return match ($valueType) {
            'integer' => (int) $this->value,
            'boolean' => (bool) $this->value,
            default => $this->value,
        };
    }
}
