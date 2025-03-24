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
        'slug'
    ];

    protected $casts = [
        'is_active' => 'boolean',
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
        return 'id';
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
}
