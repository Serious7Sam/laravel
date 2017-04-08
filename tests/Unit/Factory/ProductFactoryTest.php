<?php

namespace Tests\Unit\Factory;

use App\Entity\Product;
use App\Factory\ProductFactory;

class ProductFactoryTest extends \PHPUnit_Framework_TestCase
{
    const NAME = 'test';
    const PRICE = 11.345;
    const ACTIVE = true;

    public function testCreateBuildsCorrectProduct()
    {
        $product = new Product();
        $product->setName(self::NAME)
            ->setPrice(self::PRICE)
            ->setActive(self::ACTIVE);


        $factory = new ProductFactory();
        $actual = $factory->create(self::NAME, self::PRICE, self::ACTIVE);

        static::assertEquals($product, $actual);
    }
}
