<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use App\Models\Order;
use App\Models\Product;
use App\Enums\OrderStatusEnum;
use App\Models\Category;
use App\Models\OrderProduct;
use App\Services\OrderService;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;
use Spatie\Browsershot\Browsershot;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function query()
    {
        return DB::table('products')
            ->join('order_product', 'products.id', '=', 'order_product.product_id')
            ->join('orders', 'order_product.order_id', '=', 'orders.id')
            ->orderBy('orders.date', 'desc')
            ->select('products.*', 'order_product.quantity', 'order_product.unit_price', 'order_product.sale_price', 'orders.date')
            ->get();
    }

    public function showOrder($id)
    {
        $order = Order::where('id', $id)
            ->with(
                [
                    'orderProducts' => fn ($query) => $query->with('product'),
                    'supplier'
                ]
            )
            ->first();
        return view('export.order', compact('order'));
    }

    public function showSale($id)
    {
        $sale = Sale::where('id', $id)->with(
            [
                'saleProducts' => fn ($query) => $query->with('product'),
                'client'
            ]
        )->first();
        return view('export.sale', compact('sale'));
    }
}
