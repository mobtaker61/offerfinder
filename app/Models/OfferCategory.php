<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class OfferCategory extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'icon',
        'color',
        'order',
        'active',
        'parent_id',
        'description',
        'slug'
    ];

    protected $casts = [
        'active' => 'boolean',
        'order' => 'integer',
        'parent_id' => 'integer'
    ];

    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($category) {
            $category->slug = Str::slug($category->name);
        });

        static::updating(function ($category) {
            if ($category->isDirty('name')) {
                $category->slug = Str::slug($category->name);
            }
        });
    }

    /**
     * Get the parent category
     */
    public function parent()
    {
        return $this->belongsTo(OfferCategory::class, 'parent_id');
    }

    /**
     * Get the subcategories
     */
    public function children()
    {
        return $this->hasMany(OfferCategory::class, 'parent_id');
    }

    /**
     * Get all active subcategories
     */
    public function activeChildren()
    {
        return $this->children()->where('active', true);
    }

    /**
     * Check if category is a main category
     */
    public function isMainCategory()
    {
        return is_null($this->parent_id);
    }

    /**
     * Check if category has subcategories
     */
    public function hasChildren()
    {
        return $this->children()->count() > 0;
    }

    /**
     * Get all offers from this category and its subcategories
     */
    public function allOffers()
    {
        $categoryIds = $this->children()->pluck('id')->push($this->id);
        return \App\Models\Offer::whereIn('category_id', $categoryIds);
    }

    /**
     * Get direct offers of this category
     */
    public function offers()
    {
        return $this->hasMany(\App\Models\Offer::class, 'category_id');
    }

    /**
     * Get the full hierarchical path of the category
     */
    public function getFullPath()
    {
        $path = collect([$this->name]);
        $category = $this;
        
        while ($category->parent) {
            $path->prepend($category->parent->name);
            $category = $category->parent;
        }
        
        return $path->join(' > ');
    }

    /**
     * Scope a query to only include main categories
     */
    public function scopeMainCategories($query)
    {
        return $query->whereNull('parent_id');
    }

    /**
     * Scope a query to only include active categories
     */
    public function scopeActive($query)
    {
        return $query->where('active', true);
    }
}
