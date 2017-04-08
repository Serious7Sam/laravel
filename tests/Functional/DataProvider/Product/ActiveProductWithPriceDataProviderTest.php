<?php

namespace Tests\Functional\DataProvider\Product;

use App\DataProvider\Product\ActiveProductWithPriceDataProvider;
use App\Entity\Product;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class ActiveProductWithPriceDataProviderTest extends TestCase
{
    use DatabaseTransactions;

    public function testGetReturnsCorrectProduct()
    {
        $this->createProducts();

        $provider = new ActiveProductWithPriceDataProvider();
        $products = $provider->get();

        static::assertCount(1, $products);
        static::assertSame('Product 3', $products[0]->getName());
    }

    private function createProducts()
    {
        factory(Product::class)->create([
            'name' => 'Product 1',
            'price' => 10.99,
            'is_active' => 0,
        ]);

        factory(Product::class)->create([
            'name' => 'Product 2',
            'price' => 0,
            'is_active' => 1,
        ]);

        factory(Product::class)->create([
            'name' => 'Product 3',
            'price' => 56.78,
            'is_active' => 1,
        ]);
    }
}
