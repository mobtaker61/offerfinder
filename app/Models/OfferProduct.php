<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OfferProduct extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'product_id',
        'offer_id',
        'offer_image_id',
        'variant',
        'unit',
        'quantity',
        'price',
        'extracted_data'
    ];
    
    /**
     * Get the product that owns the offer product
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
    
    /**
     * Get the offer that owns the offer product
     */
    public function offer()
    {
        return $this->belongsTo(Offer::class);
    }
    
    /**
     * Get the offer image that owns the offer product
     */
    public function offerImage()
    {
        return $this->belongsTo(OfferImage::class);
    }
}
