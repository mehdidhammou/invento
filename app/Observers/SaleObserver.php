<?php

namespace App\Observers;

use App\Enums\SaleStatusEnum;
use App\Models\Sale;

class SaleObserver
{
    /**
     * Handle the Sale "created" event.
     *
     * @param  \App\Models\Sale  $sale
     * @return void
     */
    public function created(Sale $sale)
    {
        $total = 0;
        foreach ($sale->saleProducts as $saleProduct) {
            $total += $saleProduct->sale_price * $saleProduct->quantity;
        }
        $sale->total_price = $total - ($total * $sale->discount / 100);
        $sale->save();
    }

    /**
     * Handle the Sale "updated" event.
     *
     * @param  \App\Models\Sale  $sale
     * @return void
     */
    public function updated(Sale $sale)
    {
        if($sale->isDirty('status') && $sale->status != SaleStatusEnum::CANCELED->name) {
            foreach ($sale->saleProducts()->with('product')->get() as $saleProduct) {
                $saleProduct->product->total_quantity -= $saleProduct->quantity;
                $saleProduct->product->save();
            }
        }
    }

    /**
     * Handle the Sale "deleted" event.
     *
     * @param  \App\Models\Sale  $sale
     * @return void
     */
    public function deleted(Sale $sale)
    {
        //
    }

    /**
     * Handle the Sale "restored" event.
     *
     * @param  \App\Models\Sale  $sale
     * @return void
     */
    public function restored(Sale $sale)
    {
        //
    }

    /**
     * Handle the Sale "force deleted" event.
     *
     * @param  \App\Models\Sale  $sale
     * @return void
     */
    public function forceDeleted(Sale $sale)
    {
        //
    }
}
