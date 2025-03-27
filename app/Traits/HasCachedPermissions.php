<?php

namespace App\Traits;

use Illuminate\Support\Facades\Cache;

trait HasCachedPermissions
{
    /**
     * Get a cached permission value
     *
     * @param string $key
     * @return mixed
     */
    protected function getCachedPermission(string $key)
    {
        $cacheKey = "user_permissions_{$this->id}_{$key}";
        
        return Cache::remember($cacheKey, now()->addHours(24), function () use ($key) {
            return match ($key) {
                'is_webmaster' => $this->user_type === 'webmaster',
                'is_admin' => $this->user_type === 'admin',
                'is_market_admin' => $this->user_type === 'market_admin',
                'is_branch_admin' => $this->user_type === 'branch_admin',
                'is_user' => $this->user_type === 'user',
                'is_guest' => $this->user_type === 'guest',
                'has_admin_privileges' => in_array($this->user_type, ['webmaster', 'admin']),
                'has_market_admin_privileges' => in_array($this->user_type, ['webmaster', 'admin', 'market_admin']),
                'has_branch_admin_privileges' => in_array($this->user_type, ['webmaster', 'admin', 'market_admin', 'branch_admin']),
                'has_user_panel_access' => in_array($this->user_type, ['webmaster', 'admin', 'market_admin', 'branch_admin', 'user']),
                'has_public_content_access' => true, // All users can access public content
                default => false,
            };
        });
    }

    /**
     * Clear all cached permissions for this user
     *
     * @return void
     */
    public function clearPermissionCache(): void
    {
        $keys = [
            'is_webmaster',
            'is_admin',
            'is_market_admin',
            'is_branch_admin',
            'is_user',
            'is_guest',
            'has_admin_privileges',
            'has_market_admin_privileges',
            'has_branch_admin_privileges',
            'has_user_panel_access',
            'has_public_content_access'
        ];

        foreach ($keys as $key) {
            Cache::forget("user_permissions_{$this->id}_{$key}");
        }
    }
} 