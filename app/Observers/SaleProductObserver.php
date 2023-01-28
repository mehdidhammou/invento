<?php

namespace App\Observers;

use App\Models\SaleProduct;
use App\Services\SaleService;

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
        SaleService::resetTotalPrice($saleProduct->sale);
    }

    /**
     * Handle the SaleProduct "updated" event.
     *
     * @param  \App\Models\SaleProduct  $saleProduct
     * @return void
     */
    public function updated(SaleProduct $saleProduct)
    {
        if ($saleProduct->isDirty('quantity') || $saleProduct->isDirty('sale_price')) {
            SaleService::resetTotalPrice($saleProduct->sale);
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
        SaleService::resetTotalPrice($saleProduct->sale);
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
