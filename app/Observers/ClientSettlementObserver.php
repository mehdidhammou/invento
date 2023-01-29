<?php

namespace App\Observers;

use App\Models\ClientSettlement;

class ClientSettlementObserver
{
    /**
     * Handle the ClientSettlement "created" event.
     *
     * @param  \App\Models\ClientSettlement  $clientSettlement
     * @return void
     */
    public function created(ClientSettlement $clientSettlement)
    {
        $clientSettlement->sale->total_paid += $clientSettlement->amount;
        $clientSettlement->sale->save();
        
        $clientSettlement->client->balance -= $clientSettlement->amount;
        $clientSettlement->client->save();
    }

    /**
     * Handle the ClientSettlement "updated" event.
     *
     * @param  \App\Models\ClientSettlement  $clientSettlement
     * @return void
     */
    public function updated(ClientSettlement $clientSettlement)
    {
    }

    /**
     * Handle the ClientSettlement "deleted" event.
     *
     * @param  \App\Models\ClientSettlement  $clientSettlement
     * @return void
     */
    public function deleted(ClientSettlement $clientSettlement)
    {
        $clientSettlement->client->balance += $clientSettlement->amount;
        $clientSettlement->client->save();

        $clientSettlement->sale->total_paid -= $clientSettlement->amount;
        $clientSettlement->sale->save();
    }

    /**
     * Handle the ClientSettlement "restored" event.
     *
     * @param  \App\Models\ClientSettlement  $clientSettlement
     * @return void
     */
    public function restored(ClientSettlement $clientSettlement)
    {
        //
    }

    /**
     * Handle the ClientSettlement "force deleted" event.
     *
     * @param  \App\Models\ClientSettlement  $clientSettlement
     * @return void
     */
    public function forceDeleted(ClientSettlement $clientSettlement)
    {
        //
    }
}
