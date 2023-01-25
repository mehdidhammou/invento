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
    ];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }
}
