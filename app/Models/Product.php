<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use \Staudenmeir\EloquentHasManyDeep\HasRelationships;
    use HasFactory;

    protected $fillable = [
        'name',
        'total_quantity',
        'category_id',
    ];

    protected $appends = [
        'latest_unit_price',
        'latest_sale_price',
    ];

    // relationships
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function orders()
    {
        return $this->belongsToMany(Order::class)
            ->using(OrderProduct::class)
            ->withPivot('quantity', 'unit_price', 'sale_price')
            ->withTimestamps();
    }

    public function sales()
    {
        return $this->belongsToMany(Sale::class)
            ->using(SaleProduct::class)
            ->withPivot('quantity', 'unit_price', 'sale_price')
            ->withTimestamps();
    }

    public function orderProducts()
    {
        return $this->hasMany(OrderProduct::class);
    }

    public function saleProducts()
    {
        return $this->hasMany(SaleProduct::class);
    }

    // attributes
    public function latestOrderId(): Attribute
    {
        return new Attribute(
            get: fn ($value) => $this->orders()->orderBy('date', 'desc')->first()->id ?? null
        );
    }

    public function latestUnitPrice(): Attribute
    {
        return new Attribute(
            get: fn ($value) => $this->orders()->orderBy('date', 'desc')->first()->pivot->unit_price ?? 0,
        );
    }

    public function latestSalePrice(): Attribute
    {
        return new Attribute(
            get: fn ($value) => $this->orders()->orderBy('date', 'desc')->first()->pivot->sale_price ?? 0,
        );
    }

    // scopes
    public function scopeBestSelling($query)
    {
        return $query->withSum('orderProducts', 'quantity');
    }

    // public function scopeLatestPrices($query)
    // {
    //     return $query
    //         ->addSelect(DB::raw('order_product.unit_price as latest_unit_price , order_product.sale_price as latest_sale_price'))
    //         ->join('order_product', 'products.id', '=', 'order_product.product_id')
    //         ->join('orders', 'order_product.order_id', '=', 'orders.id')
    //         ->orderBy('orders.date', 'desc')
    //         ->first();
    // }
}
