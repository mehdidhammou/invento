<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'surname',
        'email',
        'phone',
        'balance',
    ];

    public function sales()
    {
        return $this->hasMany(Sale::class);
    }

    public function settlements()
    {
        return $this->hasManyThrough(ClientSettlement::class, Sale::class);
    }
}
