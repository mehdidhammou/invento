<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'supplier_id',
        'total_price',
        'total_paid',
        'delivered',
        'date',
        'status',
    ];

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    public function products()
    {
        return $this->belongsToMany(Product::class)
            ->using(OrderProduct::class)
            ->withPivot('quantity', 'unit_price', 'sale_price')
            ->withTimestamps();
    }

    public function orderProducts()
    {
        return $this->hasMany(OrderProduct::class);
    }

    public function invoices()
    {
        return $this->hasMany(Invoice::class);
    }

    public function bls()
    {
        return $this->hasMany(BL::class);
    }

    public function settlements()
    {
        return $this->hasMany(SupplierSettlement::class);
    }

}
