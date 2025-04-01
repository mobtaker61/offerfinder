<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Coupon extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'title',
        'description',
        'image',
        'start_date',
        'end_date',
        'is_unlimited',
        'usage_limit',
        'used_count',
        'is_active',
        'couponable_type',
        'couponable_id'
    ];

    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime',
        'is_unlimited' => 'boolean',
        'is_active' => 'boolean',
    ];

    /**
     * Get the parent couponable model (market or branch).
     */
    public function couponable()
    {
        return $this->morphTo();
    }

    /**
     * Scope a query to only include active coupons.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true)
                    ->where('start_date', '<=', now())
                    ->where('end_date', '>=', now())
                    ->where(function ($q) {
                        $q->where('is_unlimited', true)
                          ->orWhereRaw('used_count < usage_limit');
                    });
    }

    /**
     * Scope a query to only include expired coupons.
     */
    public function scopeExpired($query)
    {
        return $query->where('end_date', '<', now());
    }

    /**
     * Scope a query to only include upcoming coupons.
     */
    public function scopeUpcoming($query)
    {
        return $query->where('start_date', '>', now());
    }

    /**
     * Scope to get coupons for a branch including market coupons
     */
    public function scopeForBranch($query, Branch $branch)
    {
        return $query->where(function($q) use ($branch) {
            // Get branch-specific coupons
            $q->where('couponable_type', 'App\Models\Branch')
              ->where('couponable_id', $branch->id)
              // Or get market coupons
              ->orWhere(function($q) use ($branch) {
                  $q->where('couponable_type', 'App\Models\Market')
                    ->where('couponable_id', $branch->market_id);
              });
        });
    }

    /**
     * Get the image URL attribute.
     */
    public function getImageUrlAttribute()
    {
        return $this->image ? asset('storage/' . $this->image) : null;
    }

    /**
     * Check if the coupon is available for use.
     */
    public function isAvailable()
    {
        return $this->is_active &&
               $this->start_date <= now() &&
               $this->end_date >= now() &&
               ($this->is_unlimited || $this->used_count < $this->usage_limit);
    }
} 