<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
    ];


    public function products()
    {
        return $this->hasMany(Product::class);
    }


    public function scopeBestSelling($query)
    {
        return $query->selectRaw('sum(quantity) as total_sold, categories.id, categories.name')
        ->join('products', 'categories.id', '=', 'products.category_id')
        ->join('order_product', 'products.id', '=', 'order_product.product_id')
        ->groupBy('categories.id', 'categories.name')
        ->orderBy('total_sold', 'desc');
    }
}
