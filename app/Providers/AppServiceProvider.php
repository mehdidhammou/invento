<?php

namespace App\Providers;

use App\Models\Sale;
use App\Models\Order;
use App\Models\Client;
use App\Models\SaleProduct;
use App\Models\OrderProduct;
use App\Observers\SaleObserver;
use App\Models\ClientSettlement;
use App\Observers\OrderObserver;
use App\Observers\ClientObserver;
use App\Models\SupplierSettlement;
use App\Observers\SaleProductObserver;
use App\Observers\OrderProductObserver;
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
        // client side
        Client::observe(ClientObserver::class);
        ClientSettlement::observe(ClientSettlementObserver::class);
        Sale::observe(SaleObserver::class);
        SaleProduct::observe(SaleProductObserver::class);

        // supplier side
        SupplierSettlement::observe(SupplierSettlementObserver::class);
        Order::observe(OrderObserver::class);
        OrderProduct::observe(OrderProductObserver::class);
    }
}
