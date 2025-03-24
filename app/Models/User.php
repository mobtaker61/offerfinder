<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasApiTokens, HasFactory, Notifiable;

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
     * User types constants
     */
    const TYPE_WEBMASTER = 'webmaster';
    const TYPE_ADMIN = 'admin';
    const TYPE_MANAGER = 'manager';
    const TYPE_STAFF = 'staff';
    const TYPE_USER = 'user';

    /**
     * Get all available user types
     *
     * @return array
     */
    public static function getUserTypes(): array
    {
        return [
            self::TYPE_WEBMASTER => 'Webmaster',
            self::TYPE_ADMIN => 'Admin',
            self::TYPE_MANAGER => 'Manager',
            self::TYPE_STAFF => 'Staff',
            self::TYPE_USER => 'User',
        ];
    }

    /**
     * Check if user is webmaster
     *
     * @return bool
     */
    public function isWebmaster(): bool
    {
        return $this->user_type === self::TYPE_WEBMASTER;
    }

    /**
     * Check if user is admin
     *
     * @return bool
     */
    public function isAdmin(): bool
    {
        return $this->user_type === self::TYPE_ADMIN;
    }

    /**
     * Check if user is manager
     *
     * @return bool
     */
    public function isManager(): bool
    {
        return $this->user_type === self::TYPE_MANAGER;
    }

    /**
     * Check if user is staff
     *
     * @return bool
     */
    public function isStaff(): bool
    {
        return $this->user_type === self::TYPE_STAFF;
    }

    /**
     * Check if user is regular user
     *
     * @return bool
     */
    public function isUser(): bool
    {
        return $this->user_type === self::TYPE_USER;
    }

    /**
     * Check if user has admin privileges
     *
     * @return bool
     */
    public function hasAdminPrivileges(): bool
    {
        return in_array($this->user_type, [self::TYPE_WEBMASTER, self::TYPE_ADMIN]);
    }

    /**
     * Check if user has manager privileges
     *
     * @return bool
     */
    public function hasManagerPrivileges(): bool
    {
        return in_array($this->user_type, [self::TYPE_WEBMASTER, self::TYPE_ADMIN, self::TYPE_MANAGER]);
    }

    /**
     * Check if user has staff privileges
     *
     * @return bool
     */
    public function hasStaffPrivileges(): bool
    {
        return in_array($this->user_type, [self::TYPE_WEBMASTER, self::TYPE_ADMIN, self::TYPE_MANAGER, self::TYPE_STAFF]);
    }
}
