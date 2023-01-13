<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'price',
        'total_quantity',
        'product_type_id',
    ];


    public function productType()
    {
        return $this->belongsTo(ProductType::class);
    }

    public function purchases()
    {
        return $this->hasMany(Purchase::class);
    }

    public function orders()
    {
        return $this->belongsToMany(Order::class)
            ->using(OrderProduct::class)
            ->withPivot('quantity', 'price')
            ->withTimestamps();
    }

    public function clients()
    {
        return $this->hasManyDeep(Client::class, [Order::class, OrderProduct::class]);
    }
}
