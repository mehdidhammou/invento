<?php

namespace App\Models;

use Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'total_quantity',
        'category_id',
    ];


    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // public function orders()
    // {
    //     return $this->belongsToMany(Order::class)
    //         ->using(OrderProduct::class)
    //         ->withPivot('quantity', 'unit_price', 'sale_price')
    //         ->withTimestamps();
    // }

    public function orderProducts()
    {
        return $this->hasMany(OrderProduct::class);
    }

    public function sales()
    {
        return $this->belongsToMany(Sale::class)
            ->using(SaleProduct::class)
            ->withPivot('quantity', 'unit_price', 'sale_price')
            ->withTimestamps();
    }
}
