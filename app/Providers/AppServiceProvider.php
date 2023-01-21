<?php

namespace App\Providers;

use App\Models\Client;
use App\Models\ClientSettlement;
use App\Observers\ClientObserver;
use App\Observers\ClientSettlementObserver;
use Illuminate\Support\ServiceProvider;

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
        if($this->app->environment('production')) {
            \URL::forceScheme('https');
        }

        Client::observe(ClientObserver::class);
        ClientSettlement::observe(ClientSettlementObserver::class);
    }
}
