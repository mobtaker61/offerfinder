<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class PermissionGroup extends Model
{
    protected $fillable = [
        'name',
        'description',
        'permissions'
    ];

    protected $casts = [
        'permissions' => 'array'
    ];

    /**
     * Get the users that belong to this permission group
     */
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'user_permission_groups')
            ->withTimestamps();
    }
} 