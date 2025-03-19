<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Market extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'local_name',
        'logo',
        'avatar',
        'website',
        'android_app_link',
        'ios_app_link',
        'whatsapp',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function branches(): HasMany
    {
        return $this->hasMany(Branch::class);
    }
    
    public function emirate()
    {
        return $this->belongsTo(Emirate::class);
    }
}
