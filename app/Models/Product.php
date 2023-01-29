<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
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
        'latest_order_id',
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
            get: fn ($value) => $this->orderProducts(function ($query){
                return $query->whereHas('order', fn($query) => $query->where('delivered', 1));
            })->latest()->first()->order_id ?? 0
        );
    }

    public function latestUnitPrice(): Attribute
    {
        return new Attribute(
            get: fn ($value) => $this->orderProducts(function ($query){
                return $query->whereHas('order', fn($query) => $query->where('delivered', 1));
            })->latest()->first()->unit_price ?? 0
        );
    }

    public function latestSalePrice(): Attribute
    {
        return new Attribute(
            get: fn ($value) => $this->orderProducts(function ($query){
                return $query->whereHas('order', fn($query) => $query->where('delivered', 1));
            })->latest()->first()->sale_price ?? 0
        );
    }

    // scopes
    public function scopeBestSelling($query)
    {
        return $query->withSum('orderProducts', 'quantity');
    }

    public function scopeLatestPrices($query)
    {
        return $query->with('orderProducts', function ($query) {
            $query->whereHas('order', fn ($query) => $query->where('delivered', 1))->latest();
        });
    }
}
