<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use App\Models\Order;
use App\Models\Invoice;
use App\Models\Product;
use App\Models\Category;
use App\Models\OrderProduct;
use App\Enums\OrderStatusEnum;
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
        return Product::where('id', 1)->latestPrices()->first();
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

    public function showInvoice($id)
    {
        $invoice = Invoice::where('order_id', $id)->with(
            'order',
            fn ($query) => $query->with(
                [
                    'orderProducts' => fn ($query) => $query->with('product'),
                    'supplier'
                ]
            )
        )->first();

        return view('export.invoice', compact('invoice'));
    }

    public function showBl($id)
    {
        $bl = Invoice::where('order_id', $id)->with(
            'order',
            fn ($query) => $query->with(
                [
                    'orderProducts' => fn ($query) => $query->with('product'),
                    'supplier'
                ]
            )
        )->first();

        return view('export.bl', compact('bl'));
    }
}
