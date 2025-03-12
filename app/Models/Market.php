<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Market extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'logo', 'website', 'app_link', 'whatsapp'
    ];

    public function branches()
    {
        return $this->hasMany(Branch::class);
    }
}
