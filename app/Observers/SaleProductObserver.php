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
        $saleProduct->sale->total_price += $saleProduct->sale_price * $saleProduct->quantity;
        $saleProduct->sale->save();
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
            $saleProduct->sale->total_price += ($saleProduct->sale_price * $saleProduct->quantity) - ($saleProduct->sale_price * $saleProduct->getOriginal('quantity'));
            $saleProduct->sale->save();
        }
        
        if($saleProduct->isDirty('sale_price')) {
            $saleProduct->sale->total_price += ($saleProduct->sale_price * $saleProduct->quantity) - ($saleProduct->getOriginal('sale_price') * $saleProduct->quantity);
            $saleProduct->sale->save();
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
