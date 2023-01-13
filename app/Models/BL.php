<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BL extends Model
{
    use HasFactory;

    protected $fillable = [
        'number',
        'date',
        'order_id',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
