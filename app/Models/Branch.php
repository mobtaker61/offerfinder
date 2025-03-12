<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Branch extends Model
{
    use HasFactory;

    protected $fillable = ['market_id', 'name', 'location', 'address', 'working_hours', 'customer_service', 'emirate_id'];

    public function market()
    {
        return $this->belongsTo(Market::class);
    }

    public function offers()
    {
        return $this->belongsToMany(Offer::class, 'offer_branch');
    }

    public function emirate()
    {
        return $this->belongsTo(Emirate::class);
    }
}
