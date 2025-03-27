<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Auth;

abstract class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    /**
     * Get the authenticated user
     *
     * @return \App\Models\User|null
     */
    protected function user()
    {
        return Auth::user();
    }

    /**
     * Check if the authenticated user is a webmaster
     *
     * @return bool
     */
    protected function isWebmaster(): bool
    {
        return $this->user()?->isWebmaster() ?? false;
    }

    /**
     * Check if the authenticated user is an admin
     *
     * @return bool
     */
    protected function isAdmin(): bool
    {
        return $this->user()?->isAdmin() ?? false;
    }

    /**
     * Check if the authenticated user is a market admin
     *
     * @return bool
     */
    protected function isMarketAdmin(): bool
    {
        return $this->user()?->isMarketAdmin() ?? false;
    }

    /**
     * Check if the authenticated user is a branch admin
     *
     * @return bool
     */
    protected function isBranchAdmin(): bool
    {
        return $this->user()?->isBranchAdmin() ?? false;
    }

    /**
     * Check if the authenticated user is a regular user
     *
     * @return bool
     */
    protected function isUser(): bool
    {
        return $this->user()?->isUser() ?? false;
    }

    /**
     * Check if the authenticated user is a guest
     *
     * @return bool
     */
    protected function isGuest(): bool
    {
        return $this->user()?->isGuest() ?? false;
    }

    /**
     * Check if the authenticated user has admin privileges
     *
     * @return bool
     */
    protected function hasAdminPrivileges(): bool
    {
        return $this->user()?->hasAdminPrivileges() ?? false;
    }

    /**
     * Check if the authenticated user has market admin privileges
     *
     * @return bool
     */
    protected function hasMarketAdminPrivileges(): bool
    {
        return $this->user()?->hasMarketAdminPrivileges() ?? false;
    }

    /**
     * Check if the authenticated user has branch admin privileges
     *
     * @return bool
     */
    protected function hasBranchAdminPrivileges(): bool
    {
        return $this->user()?->hasBranchAdminPrivileges() ?? false;
    }

    /**
     * Check if the authenticated user has user panel access
     *
     * @return bool
     */
    protected function hasUserPanelAccess(): bool
    {
        return $this->user()?->hasUserPanelAccess() ?? false;
    }

    /**
     * Check if the authenticated user has public content access
     *
     * @return bool
     */
    protected function hasPublicContentAccess(): bool
    {
        return $this->user()?->hasPublicContentAccess() ?? false;
    }

    /**
     * Authorize a user to perform an action based on their role
     *
     * @param string $role
     * @return void
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    protected function authorizeRole(string $role): void
    {
        $hasAccess = false;

        switch ($role) {
            case 'webmaster':
                $hasAccess = $this->isWebmaster();
                break;
            case 'admin':
                $hasAccess = $this->hasAdminPrivileges();
                break;
            case 'market_admin':
                $hasAccess = $this->hasMarketAdminPrivileges();
                break;
            case 'branch_admin':
                $hasAccess = $this->hasBranchAdminPrivileges();
                break;
            case 'user':
                $hasAccess = $this->hasUserPanelAccess();
                break;
            case 'guest':
                $hasAccess = $this->hasPublicContentAccess();
                break;
        }

        if (!$hasAccess) {
            abort(403, 'Unauthorized action.');
        }
    }
}
