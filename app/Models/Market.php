<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Market extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'logo', 'website', 'app_link', 'whatsapp', 'emirate_id'
    ];

    public function branches()
    {
        return $this->hasMany(Branch::class);
    }
    
    public function emirate()
    {
        return $this->belongsTo(Emirate::class);
    }
}
