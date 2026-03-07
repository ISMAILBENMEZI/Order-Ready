<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Store extends Model
{
    protected $fillable = [
        'seller_id',
        'name',
        'description',
        'logo_url',
        'banner_url',
        'location',
        'contact_email',
        'contact_phone',
        'status'
    ];

    public function seller()
    {
        return $this->belongsTo(User::class , 'seller_id');
    }
    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
