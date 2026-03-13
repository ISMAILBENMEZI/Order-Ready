<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'store_id',
        'category_id',
        'name',
        'description',
        'price',
        'discount_price',
        'is_negotiable',
        'status'
    ];

    public function store()
    {
        return $this->belongsTo(Store::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function images()
    {
        return $this->hasMany(ProeductImage::class);
    }

    public function favorites()
    {
        return $this->hasMany(Favorite::class);
    }

    public function interestRequests()
    {
        return $this->hasMany(InterestRequest::class);
    }

    public function ratings()
    {
        return $this->hasMany(Rating::class);
    }

    public function reports()
    {
        return $this->hasMany(Report::class);
    }
}
