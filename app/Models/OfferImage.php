<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OfferImage extends Model
{
    use HasFactory;

    protected $fillable = ['offer_id', 'image'];

    public function offer()
    {
        return $this->belongsTo(Offer::class);
    }

    /**
     * Get the offer products for this offer image
     */
    public function offerProducts()
    {
        return $this->hasMany(OfferProduct::class);
    }
}
