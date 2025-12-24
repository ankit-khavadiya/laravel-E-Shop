<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = [
        'id',
        'parent_id',
        'name',
        'description',
        'is_active',
    ];

    protected $table = 'categories';

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }
    public function products(){
        return $this->hasMany(Product::class);
    }
}
