<?php

namespace App\Observers;

use App\Models\Sale;
use App\Models\Client;
use App\Enums\SaleStatusEnum;
use App\Services\SaleService;
use Filament\Notifications\Notification;

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
    }

    /**
     * Handle the Sale "updated" event.
     *
     * @param  \App\Models\Sale  $sale
     * @return void
     */
    public function updated(Sale $sale)
    {
        if ($sale->isDirty('purchased')) {
            if ($sale->purchased) {
                SaleService::resetTotalPrice($sale);
                SaleService::destockProducts($sale);
                SaleService::addBalanceToClient($sale);
            }
        }

        if ($sale->isDirty('total_paid')) {
            if ($sale->total_paid == $sale->total_price) {
                $sale->status = saleStatusEnum::PAID->name;
                Notification::make()
                    ->success()
                    ->title('Congrats!, sale has been fully paid')
                    ->send();
            } else {
                $sale->status = saleStatusEnum::UNPAID->name;
            }
            $sale->saveQuietly();
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
