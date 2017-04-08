<?php

namespace App\DataProvider\Product;

use App\Entity\Product;

interface ProductsDataProviderInterface
{
    /**
     * @return Product[]
     */
    public function get();
}
