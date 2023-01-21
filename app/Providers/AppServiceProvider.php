<?php

namespace App\Providers;

use App\Models\Client;
use App\Models\ClientSettlement;
use App\Observers\ClientObserver;
use App\Models\SupplierSettlement;
use Illuminate\Support\ServiceProvider;
use App\Observers\ClientSettlementObserver;
use App\Observers\SupplierSettlementObserver;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        if ($this->app->environment('production')) {
            \URL::forceScheme('https');
        }

        Client::observe(ClientObserver::class);
        ClientSettlement::observe(ClientSettlementObserver::class);
        SupplierSettlement::observe(SupplierSettlementObserver::class);
    }
}
