<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'condition_id',
        'name',
        'brand',
        'description',
        'image',
        'category',
        'condition',
        'price',
        'is_sold',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function condition()
    {
        return $this->belongsTo(Condition::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function purchases()
    {
        return $this->hasMany(Purchase::class);
    }

    public function favorites()
    {
        return $this->hasMany(Favorite::class);
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'product_categories');
    }
}
