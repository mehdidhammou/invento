<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClientSettlement extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_id',
        'amount',
        'date',
        'sale_id',        
    ];

    public function sale()
    {
        return $this->belongsTo(Sale::class);
    }
}
