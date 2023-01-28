<?php

namespace App\Observers;

use App\Models\SupplierSettlement;

class SupplierSettlementObserver
{
    /**
     * Handle the SupplierSettlement "created" event.
     *
     * @param  \App\Models\SupplierSettlement  $supplierSettlement
     * @return void
     */
    public function created(SupplierSettlement $supplierSettlement)
    {
        $supplierSettlement->supplier->balance -= $supplierSettlement->amount;
        $supplierSettlement->supplier->save();

        $supplierSettlement->order->total_paid += $supplierSettlement->amount;
        $supplierSettlement->order->save();
    }

    /**
     * Handle the SupplierSettlement "updated" event.
     *
     * @param  \App\Models\SupplierSettlement  $supplierSettlement
     * @return void
     */
    public function updated(SupplierSettlement $supplierSettlement)
    {
        
    }

    /**
     * Handle the SupplierSettlement "deleted" event.
     *
     * @param  \App\Models\SupplierSettlement  $supplierSettlement
     * @return void
     */
    public function deleted(SupplierSettlement $supplierSettlement)
    {
        $supplier = $supplierSettlement->supplier;
        $supplier->balance += $supplierSettlement->amount;

        $order = $supplierSettlement->order;
        $order->total_paid -= $supplierSettlement->amount;

        $order->save();
        $supplier->save();
    }

    /**
     * Handle the SupplierSettlement "restored" event.
     *
     * @param  \App\Models\SupplierSettlement  $supplierSettlement
     * @return void
     */
    public function restored(SupplierSettlement $supplierSettlement)
    {
        //
    }

    /**
     * Handle the SupplierSettlement "force deleted" event.
     *
     * @param  \App\Models\SupplierSettlement  $supplierSettlement
     * @return void
     */
    public function forceDeleted(SupplierSettlement $supplierSettlement)
    {
        //
    }
}
