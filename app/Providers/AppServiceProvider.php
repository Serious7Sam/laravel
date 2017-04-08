<?php

namespace App\Providers;

use App\DataProvider\Product\ProductsDataProviderInterface;
use App\DataProvider\Product\ActiveProductWithPriceDataProvider;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton(ProductsDataProviderInterface::class, function () {
            return new ActiveProductWithPriceDataProvider();
        });
    }
}
