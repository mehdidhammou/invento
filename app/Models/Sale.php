<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_id',
        'total_price',
        'total_paid',
        'discount',
        'date',
        'status',
    ];

    protected $casts = [
        'date' => 'date',
    ];


    // public function products()
    // {
    //     return $this->belongsToMany(Product::class)
    //         ->using(SaleProduct::class)
    //         ->withPivot('quantity', 'unit_price', 'sale_price')
    //         ->withTimestamps();
    // }

    public function saleProducts()
    {
        return $this->hasMany(SaleProduct::class);
    }

    public function client()
    {
        return $this->belongsTo(Client::class);
    }
}
