<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Traits\HasViewCount;
use Illuminate\Support\Str;

class Branch extends Model
{
    use HasFactory, HasViewCount;

    protected $fillable = [
        'name',
        'slug',
        'market_id',
        'emirate_id',
        'address',
        'phone',
        'email',
        'working_hours',
        'location',
        'is_active',
        'view_count'
    ];

    protected $casts = [
        'latitude' => 'decimal:8',
        'longitude' => 'decimal:8',
        'is_active' => 'boolean'
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($branch) {
            $marketSlug = $branch->market ? \Illuminate\Support\Str::slug($branch->market->name) : '';
            $baseSlug = $marketSlug ? $marketSlug . '-' . \Illuminate\Support\Str::slug($branch->name) : \Illuminate\Support\Str::slug($branch->name);
            $slug = $baseSlug;
            $counter = 1;

            // If slug already exists, append a number
            while (static::where('slug', $slug)->exists()) {
                $slug = $baseSlug . '-' . $counter;
                $counter++;
            }

            $branch->slug = $slug;
        });

        static::updating(function ($branch) {
            if ($branch->isDirty('name') || $branch->isDirty('market_id')) {
                $marketSlug = $branch->market ? \Illuminate\Support\Str::slug($branch->market->name) : '';
                $baseSlug = $marketSlug ? $marketSlug . '-' . \Illuminate\Support\Str::slug($branch->name) : \Illuminate\Support\Str::slug($branch->name);
                $slug = $baseSlug;
                $counter = 1;

                // If slug already exists, append a number
                while (static::where('slug', $slug)->where('id', '!=', $branch->id)->exists()) {
                    $slug = $baseSlug . '-' . $counter;
                    $counter++;
                }

                $branch->slug = $slug;
            }
        });
    }

    public function emirate()
    {
        return $this->belongsTo(Emirate::class);
    }

    public function district()
    {
        return $this->belongsTo(District::class);
    }

    public function market()
    {
        return $this->belongsTo(Market::class);
    }

    public function neighbours(): BelongsToMany
    {
        return $this->belongsToMany(Neighbour::class, 'branch_neighbour')
            ->withTimestamps();
    }

    public function offers(): BelongsToMany
    {
        return $this->belongsToMany(Offer::class, 'offer_branch')
            ->withTimestamps();
    }

    public function contactProfiles(): HasMany
    {
        return $this->hasMany(BranchContactProfile::class);
    }

    /**
     * The users that belong to the branch.
     */
    public function users()
    {
        return $this->belongsToMany(User::class, 'user_branch_assignments')
            ->withTimestamps();
    }

    /**
     * Get the branch admins.
     */
    public function admins()
    {
        return $this->belongsToMany(User::class, 'user_branch_assignments')
            ->where('user_type', User::TYPE_BRANCH_ADMIN)
            ->withTimestamps();
    }

    public function plan()
    {
        return $this->belongsTo(Plan::class);
    }

    /**
     * Get the coupons for this branch.
     */
    public function coupons()
    {
        return $this->morphMany(Coupon::class, 'couponable');
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }
}
