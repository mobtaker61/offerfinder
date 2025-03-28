<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Traits\HasCachedPermissions;
use App\Traits\HasRoleBasedUI;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasApiTokens, HasFactory, Notifiable, HasCachedPermissions, HasRoleBasedUI;

    // User Types
    public const TYPE_WEBMASTER = 'webmaster';
    public const TYPE_ADMIN = 'admin';
    public const TYPE_MARKET_ADMIN = 'market_admin';
    public const TYPE_BRANCH_ADMIN = 'branch_admin';
    public const TYPE_USER = 'user';
    public const TYPE_GUEST = 'guest';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'newsletter',
        'is_active',
        'user_type',
        'phone',
        'avatar',
        'bio',
        'location',
        'birth_date',
        'gender',
        'facebook_url',
        'twitter_url',
        'instagram_url',
        'linkedin_url',
        'email_notifications',
        'push_notifications',
        'sms_notifications',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'is_active' => 'boolean',
        'newsletter' => 'boolean',
        'email_notifications' => 'boolean',
        'push_notifications' => 'boolean',
        'sms_notifications' => 'boolean',
        'birth_date' => 'date',
    ];

    /**
     * Get all available user types
     *
     * @return array
     */
    public static function getUserTypes(): array
    {
        return [
            self::TYPE_WEBMASTER => 'Webmaster',
            self::TYPE_ADMIN => 'Admin User',
            self::TYPE_MARKET_ADMIN => 'Market Admin',
            self::TYPE_BRANCH_ADMIN => 'Branch Admin',
            self::TYPE_USER => 'User',
            self::TYPE_GUEST => 'Guest',
        ];
    }

    /**
     * Check if user is webmaster
     *
     * @return bool
     */
    public function isWebmaster(): bool
    {
        return $this->getCachedPermission('is_webmaster');
    }

    /**
     * Check if user is admin
     *
     * @return bool
     */
    public function isAdmin(): bool
    {
        return $this->getCachedPermission('is_admin');
    }

    /**
     * Check if user is market admin
     *
     * @return bool
     */
    public function isMarketAdmin(): bool
    {
        return $this->getCachedPermission('is_market_admin');
    }

    /**
     * Check if user is branch admin
     *
     * @return bool
     */
    public function isBranchAdmin(): bool
    {
        return $this->getCachedPermission('is_branch_admin');
    }

    /**
     * Check if user is regular user
     *
     * @return bool
     */
    public function isUser(): bool
    {
        return $this->getCachedPermission('is_user');
    }

    /**
     * Check if user is guest
     *
     * @return bool
     */
    public function isGuest(): bool
    {
        return $this->getCachedPermission('is_guest');
    }

    /**
     * Check if user has admin privileges
     *
     * @return bool
     */
    public function hasAdminPrivileges(): bool
    {
        return $this->getCachedPermission('has_admin_privileges');
    }

    /**
     * Check if user has market admin privileges
     *
     * @return bool
     */
    public function hasMarketAdminPrivileges(): bool
    {
        return $this->getCachedPermission('has_market_admin_privileges');
    }

    /**
     * Check if user has branch admin privileges
     *
     * @return bool
     */
    public function hasBranchAdminPrivileges(): bool
    {
        return $this->getCachedPermission('has_branch_admin_privileges');
    }

    /**
     * Check if user has user panel access
     *
     * @return bool
     */
    public function hasUserPanelAccess(): bool
    {
        return $this->getCachedPermission('has_user_panel_access');
    }

    /**
     * Check if user has public content access
     *
     * @return bool
     */
    public function hasPublicContentAccess(): bool
    {
        return $this->getCachedPermission('has_public_content_access');
    }

    /**
     * Get the user's permission groups
     */
    public function permissionGroups()
    {
        return $this->belongsToMany(PermissionGroup::class, 'user_permission_groups')
            ->withTimestamps();
    }

    /**
     * Get the markets assigned to the user
     */
    public function markets()
    {
        return $this->belongsToMany(Market::class, 'user_market_assignments')
            ->withTimestamps();
    }

    /**
     * Get the branches assigned to the user
     */
    public function branches()
    {
        return $this->belongsToMany(Branch::class, 'user_branch_assignments')
            ->withTimestamps();
    }

    /**
     * Get the user's wallet
     */
    public function wallet()
    {
        return $this->hasOne(Wallet::class);
    }

    /**
     * Get the user's wallet transactions
     */
    public function walletTransactions()
    {
        return $this->hasMany(WalletTransaction::class);
    }

    /**
     * Get the user's wallet balance
     */
    public function getWalletBalanceAttribute()
    {
        return $this->wallet?->balance ?? 0;
    }

    /**
     * Check if user has a specific permission
     */
    public function hasPermission(string $permission): bool
    {
        // Check user type permissions first
        if ($this->getCachedPermission($permission)) {
            return true;
        }

        // Then check permission groups
        return $this->permissionGroups()
            ->whereJsonContains('permissions', $permission)
            ->exists();
    }

    /**
     * The "booted" method of the model.
     */
    protected static function booted(): void
    {
        static::updated(function ($user) {
            $user->clearPermissionCache();
        });
    }
}
