<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

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
        'vip', // Add vip to fillable properties
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
}
