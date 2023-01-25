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

        $minYear =  Sale::min('date')->date_format('Y');
        return $minYear;
    }

    public function showOrder($id)
    {
        $order = Order::where('id', 11)
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
