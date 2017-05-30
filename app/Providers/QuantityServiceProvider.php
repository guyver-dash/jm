<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repo\Quantity\QuantityInterface;
use App\Repo\Quantity\QuantityRepository;
use App\Http\Controllers\Quantity\AreaManagerQuantityController;

class QuantityServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->when(AreaManagerQuantityController::class)
          ->needs(QuantityInterface::class)
          ->give(QuantityRepository::class);

    }
}
