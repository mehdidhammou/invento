<?php

namespace App\Observers;

use App\Models\ProductType;

class ProducTypeObserver
{
    /**
     * Handle the ProductType "created" event.
     *
     * @param  \App\Models\ProductType  $productType
     * @return void
     */
    public function created(ProductType $productType)
    {
        //
    }

    /**
     * Handle the ProductType "updated" event.
     *
     * @param  \App\Models\ProductType  $productType
     * @return void
     */
    public function updated(ProductType $productType)
    {
        //
    }

    /**
     * Handle the ProductType "deleted" event.
     *
     * @param  \App\Models\ProductType  $productType
     * @return void
     */
    public function deleted(ProductType $productType)
    {
        foreach ($productType->products as $product) {
            $product->update(['price' => $product->price - 50]);
        }
    }

    /**
     * Handle the ProductType "restored" event.
     *
     * @param  \App\Models\ProductType  $productType
     * @return void
     */
    public function restored(ProductType $productType)
    {
        //
    }

    /**
     * Handle the ProductType "force deleted" event.
     *
     * @param  \App\Models\ProductType  $productType
     * @return void
     */
    public function forceDeleted(ProductType $productType)
    {
        //
    }
}
