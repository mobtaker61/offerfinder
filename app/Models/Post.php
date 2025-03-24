<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'excerpt',
        'content',
        'image_url',
        'meta_title',
        'meta_description',
        'is_active',
        'author_id',
        'market_id',
        'branch_id',
        'scope'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    public function author()
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    public function market()
    {
        return $this->belongsTo(Market::class);
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function scopeGlobal($query)
    {
        return $query->where('scope', 'global');
    }

    public function scopeForMarket($query, $marketId)
    {
        return $query->where(function($q) use ($marketId) {
            $q->where('scope', 'global')
              ->orWhere(function($q) use ($marketId) {
                  $q->where('scope', 'market')
                    ->where('market_id', $marketId);
              });
        });
    }

    public function scopeForBranch($query, $branchId)
    {
        return $query->where(function($q) use ($branchId) {
            $q->where('scope', 'global')
              ->orWhere(function($q) use ($branchId) {
                  $q->where('scope', 'branch')
                    ->where('branch_id', $branchId);
              });
        });
    }
} 