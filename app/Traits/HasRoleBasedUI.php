<?php

namespace App\Traits;

use App\Models\User;
use Illuminate\Support\Facades\Auth;

trait HasRoleBasedUI
{
    /**
     * Check if user can see the component
     *
     * @param string $component
     * @return bool
     */
    public function canSeeComponent(string $component): bool
    {
        /** @var User $user */
        $user = Auth::user();

        if (!$user) {
            return false;
        }

        return match ($component) {
            'admin-panel' => $user->hasAdminPrivileges(),
            'market-panel' => $user->hasMarketAdminPrivileges(),
            'branch-panel' => $user->hasBranchAdminPrivileges(),
            'user-panel' => $user->hasUserPanelAccess(),
            'public-content' => $user->hasPublicContentAccess(),
            default => false,
        };
    }

    /**
     * Get user's allowed components
     *
     * @return array
     */
    public function getAllowedComponents(): array
    {
        /** @var User $user */
        $user = Auth::user();

        if (!$user) {
            return [];
        }

        $components = [];
        if ($user->hasAdminPrivileges()) $components[] = 'admin-panel';
        if ($user->hasMarketAdminPrivileges()) $components[] = 'market-panel';
        if ($user->hasBranchAdminPrivileges()) $components[] = 'branch-panel';
        if ($user->hasUserPanelAccess()) $components[] = 'user-panel';
        if ($user->hasPublicContentAccess()) $components[] = 'public-content';

        return $components;
    }
} 