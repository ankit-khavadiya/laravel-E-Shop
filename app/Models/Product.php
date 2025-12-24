<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = 'products';

    protected $fillable = [
        'id',
        'category_id',
        'name',
        'description',
        'short_description',
        'price',
        'discount_price',
        'quantity',
        'is_active',
        'is_featured',
        'image',
        'gallery_images',
        'dimensions',
        'meta_title',
        'meta_description',
        'meta_keyword',
        'rating',
        'reviews_count'
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    public function category(){
        return $this->belongsTo(Category::class);
    }
}
