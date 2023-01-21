<?php

namespace App\Models;

use App\Enums\OrderStatusEnum;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'total_quantity',
        'category_id',
    ];

    protected $appends = [
        'latest_price',
        'latest_order',
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

    public function getLatestPriceAttribute()
    {
        return DB::table('order_product')
            ->join('orders', 'orders.id', '=', 'order_product.order_id')
            ->where('orders.status', '!=', OrderStatusEnum::CANCELED->name)
            ->where('product_id', $this->id)
            ->orderBy('orders.date', 'desc')
            ->first()
            ->sale_price ?? 0;
    }

    public function getLatestOrderAttribute()
    {
        return DB::table('order_product')
            ->join('orders', 'orders.id', '=', 'order_product.order_id')
            ->where('orders.status', '!=', OrderStatusEnum::CANCELED->name)
            ->where('order_product.product_id', $this->id)
            ->orderBy('orders.date', 'desc')
            ->first()
            ->order_id ?? 'N/A';
    }


    // public function sales()
    // {
    //     return $this->belongsToMany(Sale::class)
    //         ->using(SaleProduct::class)
    //         ->withPivot('quantity', 'unit_price', 'sale_price')
    //         ->withTimestamps();
    // }
}
