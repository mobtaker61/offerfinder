<?php

namespace App\Helpers;

use App\Models\Market;
use App\Models\FeatureType;

class PlanFeatureHelper
{
    /**
     * Check if a market has access to a specific feature
     *
     * @param Market|int $market The market or market ID to check
     * @param string $featureKey The feature key to check
     * @return bool Whether the market has access to the feature
     */
    public static function hasFeatureAccess(Market|int $market, string $featureKey): bool
    {
        // Get the market instance if an ID was passed
        if (is_int($market)) {
            $market = Market::find($market);
            if (!$market) {
                return false;
            }
        }
        
        // If the market doesn't have a plan assigned, return false
        if (!$market->plan) {
            return false;
        }
        
        // Check if the feature exists
        $featureType = FeatureType::where('key', $featureKey)->first();
        if (!$featureType) {
            return false;
        }
        
        // Check if the feature is included in the plan's package
        $hasFeature = $market->plan->package->featureTypes()
            ->where('feature_types.id', $featureType->id)
            ->exists();
            
        return $hasFeature;
    }
    
    /**
     * Get the value/limit for a specific feature for a market
     *
     * @param Market|int $market The market or market ID to check
     * @param string $featureKey The feature key to check
     * @param mixed $default Default value to return if the feature is not found
     * @return mixed The feature value, or default if not found
     */
    public static function getFeatureValue(Market|int $market, string $featureKey, mixed $default = null): mixed
    {
        // Get the market instance if an ID was passed
        if (is_int($market)) {
            $market = Market::find($market);
            if (!$market) {
                return $default;
            }
        }
        
        // If the market doesn't have a plan assigned, return default
        if (!$market->plan) {
            return $default;
        }
        
        // Get the feature value
        $value = $market->plan->getFeatureValue($featureKey);
        
        return $value ?? $default;
    }
    
    /**
     * Check if a market has reached the limit for a specific feature
     *
     * @param Market|int $market The market or market ID to check
     * @param string $featureKey The feature key to check
     * @param int $currentCount The current count to check against the limit
     * @return bool Whether the market has reached the limit
     */
    public static function hasReachedLimit(Market|int $market, string $featureKey, int $currentCount): bool
    {
        // Get the limit for the feature
        $limit = self::getFeatureValue($market, $featureKey, 0);
        
        // Check if the current count is equal to or exceeds the limit
        return $currentCount >= $limit;
    }
} 