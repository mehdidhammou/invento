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
        $client = $clientSettlement->client;
        $client->balance -= $clientSettlement->amount;
        $client->save();
    }

    /**
     * Handle the ClientSettlement "updated" event.
     *
     * @param  \App\Models\ClientSettlement  $clientSettlement
     * @return void
     */
    public function updated(ClientSettlement $clientSettlement)
    {
        if ($clientSettlement->isDirty('amount')) {
            $client = $clientSettlement->client;
            $client->balance += $clientSettlement->getOriginal('amount');
            $client->balance -= $clientSettlement->amount;
            $client->save();
        }
    }

    /**
     * Handle the ClientSettlement "deleted" event.
     *
     * @param  \App\Models\ClientSettlement  $clientSettlement
     * @return void
     */
    public function deleted(ClientSettlement $clientSettlement)
    {
        //
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
