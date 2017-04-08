<?php

namespace App\Factory;

use App\Entity\Product;

class ProductFactory implements ProductFactoryInterface
{
    /**
     * @param string $name
     * @param float  $price
     * @param bool   $active
     *
     * @return Product
     */
    public function create(string $name, float $price, bool $active)
    {
        $product = new Product();

        $product->setName($name)
            ->setPrice($price)
            ->setActive($active);

        return $product;
    }
}
