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
        $supplierSettlement->supplier->update([
            'balance' => $supplierSettlement->supplier->balance - $supplierSettlement->amount,
        ]);
    }

    /**
     * Handle the SupplierSettlement "updated" event.
     *
     * @param  \App\Models\SupplierSettlement  $supplierSettlement
     * @return void
     */
    public function updated(SupplierSettlement $supplierSettlement)
    {
        if ($supplierSettlement->isDirty('amount')) {
            $supplier = $supplierSettlement->supplier;
            $supplier->balance += $supplierSettlement->getOriginal('amount');
            $supplier->balance -= $supplierSettlement->amount;
            $supplier->save();
        }
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
