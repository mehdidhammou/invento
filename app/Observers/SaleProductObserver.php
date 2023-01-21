<?php

namespace App\Observers;

use App\Models\SaleProduct;

class SaleProductObserver
{
    /**
     * Handle the SaleProduct "created" event.
     *
     * @param  \App\Models\SaleProduct  $saleProduct
     * @return void
     */
    public function created(SaleProduct $saleProduct)
    {
        //
    }

    /**
     * Handle the SaleProduct "updated" event.
     *
     * @param  \App\Models\SaleProduct  $saleProduct
     * @return void
     */
    public function updated(SaleProduct $saleProduct)
    {
        if ($saleProduct->isDirty('quantity')) {
            $product = $saleProduct->product;
            $product->total_quantity -= $saleProduct->quantity;
            $product->save();
        }

        if ($saleProduct->isDirty('sale_price')) {
            $sale = $saleProduct->sale;
            $sale->total_price += $saleProduct->price;
            $sale->save();
        }
    }

    /**
     * Handle the SaleProduct "deleted" event.
     *
     * @param  \App\Models\SaleProduct  $saleProduct
     * @return void
     */
    public function deleted(SaleProduct $saleProduct)
    {
        //
    }

    /**
     * Handle the SaleProduct "restored" event.
     *
     * @param  \App\Models\SaleProduct  $saleProduct
     * @return void
     */
    public function restored(SaleProduct $saleProduct)
    {
        //
    }

    /**
     * Handle the SaleProduct "force deleted" event.
     *
     * @param  \App\Models\SaleProduct  $saleProduct
     * @return void
     */
    public function forceDeleted(SaleProduct $saleProduct)
    {
        //
    }
}
