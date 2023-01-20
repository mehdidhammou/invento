<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Services\OrderService;
use Barryvdh\DomPDF\Facade\Pdf as FacadePdf;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function query()
    {

    }


    public function exportOrder($id)
    {
        $order = Order::where('id', $id)->with('orderProducts.product:id,name')->first();
        $pdf = FacadePdf::loadView('export.order', compact('order'));
        return $pdf->download(OrderService::getOrderFilename($order));
    }
}
