<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SupplierSettlement extends Model
{
    use HasFactory;

    protected $fillable = [
        'supplier_id',
        'amount',
        'date',
    ];

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }
}
