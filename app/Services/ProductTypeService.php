<?php

namespace App\Services;

use App\Models\ProductType;
use App\Models\Sale;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class ProductTypeService
{
    public static function getBestSellingTypes(): Collection
    {
        return DB::table('sales')
            ->selectRaw('sum(quantity) as quantity, product_type_id, product_types.name as product_type_name')
            ->join('products', 'sales.product_id', '=', 'products.id')
            ->join('product_types', 'products.product_type_id', '=', 'product_types.id')
            ->groupBy('product_type_id', 'product_types.name')
            ->orderBy('quantity', 'desc')
            ->get();
    }

    public static function getBestSellingProducts()
    {
        return DB::table('sales')
            ->whereBetween(
                'sales.created_at',
                [now()->subYear(), now()]
            )
            ->selectRaw('sum(quantity) as quantity, products.name')
            ->join('products', 'sales.product_id', '=', 'products.id')
            ->groupBy('product_id', 'products.name')
            ->orderBy('quantity', 'desc')
            ->get();
    }
}
