<?php

namespace App\Factory;

use App\Entity\Product;

interface ProductFactoryInterface
{
    /**
     * @param string $name
     * @param float  $price
     * @param bool   $active
     *
     * @return Product
     */
    public function create(string $name, float $price, bool $active);
}
