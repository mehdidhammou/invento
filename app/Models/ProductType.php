<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductType extends Model
{
    use HasFactory;
    use \Staudenmeir\EloquentHasManyDeep\HasRelationships;

    protected $fillable = [
        'name',
    ];

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function getClients()
    {
        return $this->products()->with('client');
    }
}
