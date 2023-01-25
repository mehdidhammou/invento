<?php

namespace App\Observers;

use App\Enums\SaleStatusEnum;
use App\Models\Client;
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

        $sale->client->balance += $sale->total_price - $sale->total_paid;
        $sale->client->save();
    }

    /**
     * Handle the Sale "updated" event.
     *
     * @param  \App\Models\Sale  $sale
     * @return void
     */
    public function updated(Sale $sale)
    {
        if ($sale->isDirty('status')) {
            if ($sale->getOriginal('status') == SaleStatusEnum::UNPAID->name && in_array($sale->status, [SaleStatusEnum::PAID->name, SaleStatusEnum::DESTOCKED->name])) {
                foreach ($sale->saleProducts()->with('product')->get() as $saleProduct) {
                    $saleProduct->product->total_quantity -= $saleProduct->quantity;
                    $saleProduct->product->save();
                }
            }
        }

        if ($sale->isDirty('discount')) {
            $total = 0;
            foreach ($sale->saleProducts as $saleProduct) {
                $total += $saleProduct->sale_price * $saleProduct->quantity;
            }
            $sale->total_price = $total - ($total * $sale->discount / 100);
        }

        if ($sale->isDirty('total_paid')) {
            if ($sale->total_paid <= $sale->total_price) {
                if ($sale->total_paid == $sale->total_price) {
                    $sale->status = SaleStatusEnum::PAID->name;
                }
                $sale->client->balance += $sale->total_price - $sale->getOriginal('total_price');
                $sale->client->save();
            }
        }

        if ($sale->isDirty('total_price')) {
            $sale->total_price = $sale->total_price - ($sale->total_price * $sale->discount / 100);
            if ($sale->getOriginal('total_price') > $sale->total_price) {
                $sale->client->balance -= $sale->total_price - $sale->getOriginal('total_price');
            } elseif ($sale->getOriginal('total_price') < $sale->total_price) {
                $sale->client->balance += $sale->total_price - $sale->getOriginal('total_price');
            }
            $sale->client->save();
        }

        $sale->saveQuietly();
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
