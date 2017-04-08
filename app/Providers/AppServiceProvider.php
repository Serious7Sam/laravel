<?php

namespace App\Providers;

use App\DataProvider\Product\ProductsDataProviderInterface;
use App\DataProvider\Product\ActiveProductWithPriceDataProvider;
use App\Factory\ProductFactory;
use App\Factory\ProductFactoryInterface;
use App\Repository\ModelManipulationRepository;
use App\Repository\ModelManipulationRepositoryInterface;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton(ProductsDataProviderInterface::class, function () {
            return new ActiveProductWithPriceDataProvider();
        });

        $this->app->singleton(ProductFactoryInterface::class, function () {
            return new ProductFactory();
        });

        $this->app->singleton(ModelManipulationRepositoryInterface::class, function () {
            return new ModelManipulationRepository();
        });
    }
}
