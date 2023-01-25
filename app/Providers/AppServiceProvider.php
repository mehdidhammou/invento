<?php

namespace App\Providers;

use App\Models\Client;
use App\Models\SaleProduct;
use App\Models\ClientSettlement;
use App\Models\Sale;
use App\Observers\ClientObserver;
use App\Models\SupplierSettlement;
use App\Observers\SaleProductObserver;
use Illuminate\Support\ServiceProvider;
use App\Observers\ClientSettlementObserver;
use App\Observers\SaleObserver;
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
        Sale::observe(SaleObserver::class);
    }
}
