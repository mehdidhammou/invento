<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    use HasFactory;


    protected $fillable = [
        'name',
        'surname',
        'email',
        'phone',
        'balance',
    ];

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function settlements()
    {
        return $this->hasManyThrough(SupplierSettlement::class, Order::class);
    }

}
