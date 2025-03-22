<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'name',
        'image',
        'barcode',
        'group_id',
        'description'
    ];
    
    /**
     * Get the related products in the same group
     */
    public function groupProducts()
    {
        return $this->hasMany(Product::class, 'group_id', 'group_id')
            ->where('id', '!=', $this->id);
    }
    
    /**
     * Get the offer products for this product
     */
    public function offerProducts()
    {
        return $this->hasMany(OfferProduct::class);
    }
    
    /**
     * Get the offers for this product
     */
    public function offers()
    {
        return $this->belongsToMany(Offer::class, 'offer_products');
    }
}
