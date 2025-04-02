<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;
use App\Traits\HasViewCount;

class Market extends Model
{
    use HasFactory, HasViewCount;

    protected $fillable = [
        'name',
        'local_name',
        'logo',
        'avatar',
        'website',
        'android_app_link',
        'ios_app_link',
        'whatsapp',
        'is_active',
        'slug',
        'banner',
        'description',
        'plan_id',
        'view_count',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'location' => 'point',
        'view_count' => 'integer',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($market) {
            $market->slug = $market->slug ?? Str::slug($market->name);
        });

        static::updating(function ($market) {
            if ($market->isDirty('name') && !$market->isDirty('slug')) {
                $market->slug = Str::slug($market->name);
            }
        });
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function branches(): HasMany
    {
        return $this->hasMany(Branch::class);
    }
    
    public function emirate()
    {
        return $this->belongsTo(Emirate::class);
    }

    public function offers()
    {
        return $this->hasMany(Offer::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'user_market_assignments')
            ->withTimestamps();
    }

    /**
     * Get the plan this market is subscribed to
     */
    public function plan()
    {
        return $this->belongsTo(Plan::class);
    }

    /**
     * Get the coupons for this market.
     */
    public function coupons()
    {
        return $this->morphMany(Coupon::class, 'couponable');
    }

    /**
     * Get the posts for this market.
     */
    public function posts()
    {
        return $this->hasMany(Post::class);
    }
}
