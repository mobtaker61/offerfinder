<?php

namespace App\Services;

use App\Models\SettingSchema;
use App\Models\SettingValue;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class SettingsService
{
    private const CACHE_KEY_PREFIX = 'settings_';
    private const CACHE_TTL = 3600; // 1 hour
    
    /**
     * Get a setting value by key
     *
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    public function get(string $key, $default = null)
    {
        $cacheKey = self::CACHE_KEY_PREFIX . $key;
        
        return Cache::remember($cacheKey, self::CACHE_TTL, function () use ($key, $default) {
            $schema = SettingSchema::where('key', $key)
                ->where('is_active', true)
                ->first();
            
            if (!$schema) {
                return $default;
            }
            
            return $schema->formatted_value ?? $default;
        });
    }
    
    /**
     * Set a setting value
     *
     * @param string $key
     * @param mixed $value
     * @param int|null $userId
     * @return bool
     */
    public function set(string $key, $value, ?int $userId = null): bool
    {
        $schema = SettingSchema::where('key', $key)
            ->where('is_active', true)
            ->first();
        
        if (!$schema) {
            Log::warning("Attempted to set non-existent setting: {$key}");
            return false;
        }
        
        try {
            // Deactivate any existing active values
            SettingValue::where('setting_schema_id', $schema->id)
                ->where('is_active', true)
                ->update(['is_active' => false]);
            
            // Create new setting value
            SettingValue::create([
                'setting_schema_id' => $schema->id,
                'value' => $value,
                'is_active' => true,
                'updated_by' => $userId,
            ]);
            
            // Clear the cache for this setting
            $this->clearCache($key);
            
            return true;
        } catch (\Exception $e) {
            Log::error("Failed to set setting value: {$e->getMessage()}");
            return false;
        }
    }
    
    /**
     * Refresh all settings in the cache
     */
    public function refreshCache(): void
    {
        $schemas = SettingSchema::where('is_active', true)->get();
        
        foreach ($schemas as $schema) {
            $this->clearCache($schema->key);
            $this->get($schema->key); // This will rebuild the cache
        }
    }
    
    /**
     * Clear the cache for a specific setting
     *
     * @param string $key
     */
    public function clearCache(string $key): void
    {
        $cacheKey = self::CACHE_KEY_PREFIX . $key;
        Cache::forget($cacheKey);
    }
    
    /**
     * Create a new setting schema
     *
     * @param array $data
     * @return SettingSchema|null
     */
    public function createSchema(array $data): ?SettingSchema
    {
        try {
            return SettingSchema::create($data);
        } catch (\Exception $e) {
            Log::error("Failed to create setting schema: {$e->getMessage()}");
            return null;
        }
    }
    
    /**
     * Update a setting schema
     *
     * @param int $id
     * @param array $data
     * @return bool
     */
    public function updateSchema(int $id, array $data): bool
    {
        try {
            $schema = SettingSchema::findOrFail($id);
            $oldKey = $schema->key;
            
            $schema->update($data);
            
            // If the key changed, clear the old cache key
            if ($oldKey !== $schema->key) {
                $this->clearCache($oldKey);
            }
            
            $this->clearCache($schema->key);
            
            return true;
        } catch (\Exception $e) {
            Log::error("Failed to update setting schema: {$e->getMessage()}");
            return false;
        }
    }
    
    /**
     * Delete a setting schema
     *
     * @param int $id
     * @return bool
     */
    public function deleteSchema(int $id): bool
    {
        try {
            $schema = SettingSchema::findOrFail($id);
            $key = $schema->key;
            
            $schema->delete();
            $this->clearCache($key);
            
            return true;
        } catch (\Exception $e) {
            Log::error("Failed to delete setting schema: {$e->getMessage()}");
            return false;
        }
    }
    
    /**
     * Get all settings grouped by their group
     *
     * @return array
     */
    public function getAllGrouped(): array
    {
        $schemas = SettingSchema::where('is_active', true)
            ->orderBy('group')
            ->orderBy('display_order')
            ->get();
        
        $result = [];
        
        foreach ($schemas as $schema) {
            if (!isset($result[$schema->group])) {
                $result[$schema->group] = [];
            }
            
            $result[$schema->group][] = [
                'id' => $schema->id,
                'key' => $schema->key,
                'label' => $schema->label,
                'description' => $schema->description,
                'data_type' => $schema->data_type,
                'options' => $schema->options_array,
                'value' => $schema->formatted_value,
                'is_required' => $schema->is_required,
            ];
        }
        
        return $result;
    }
} 