<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Yajra\DataTables\Html\Builder as HtmlBuilder;

class Offer extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'start_date',
        'end_date',
        'cover_image',
        'pdf',
        'vip',
        'category_id',
        'market_id'
    ];

    protected $casts = [
        'vip' => 'boolean',
        'start_date' => 'date',
        'end_date' => 'date'
    ];

    protected static function booted()
    {
        static::addGlobalScope('orderByEndDate', function (Builder $builder) {
            $builder->orderBy('end_date', 'asc');
        });
    }

    public function branches()
    {
        return $this->belongsToMany(Branch::class, 'offer_branch');
    }

    public function images()
    {
        return $this->hasMany(OfferImage::class);
    }

    public function market()
    {
        return $this->belongsTo(Market::class);
    }

    public function category()
    {
        return $this->belongsTo(OfferCategory::class, 'category_id');
    }

    public function getCoverImageUrlAttribute()
    {
        return $this->cover_image ? asset('storage/' . $this->cover_image) : null;
    }

    public function getPdfUrlAttribute()
    {
        return $this->pdf ? asset('storage/' . $this->pdf) : null;
    }

    public function getFormattedStartDateAttribute()
    {
        return $this->start_date ? $this->start_date->format('Y-m-d') : null;
    }

    public function getFormattedEndDateAttribute()
    {
        return $this->end_date ? $this->end_date->format('Y-m-d') : null;
    }

    public function getBranchesListAttribute()
    {
        return $this->branches->pluck('name')->implode(', ');
    }

    public function getMarketNameAttribute()
    {
        return $this->market ? $this->market->name : null;
    }

    /**
     * Get the offer products for this offer
     */
    public function offerProducts()
    {
        return $this->hasMany(OfferProduct::class);
    }

    /**
     * Get the products for this offer
     */
    public function products()
    {
        return $this->belongsToMany(Product::class, 'offer_products')
            ->withPivot(['variant', 'unit', 'quantity', 'price', 'offer_image_id'])
            ->withTimestamps();
    }
}
