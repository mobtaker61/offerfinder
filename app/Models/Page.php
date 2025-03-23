<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    protected $fillable = [
        'slug',
        'title',
        'meta_title',
        'meta_description',
        'content',
        'is_active',
        'sort_order'
    ];

    public function getRouteKeyName()
    {
        return 'slug';
    }
}
