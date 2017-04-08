<?php

namespace App\DataProvider\Product;

use App\Entity\Product;
use App\Entity\Voucher;

class ActiveProductWithPriceDataProvider implements ProductsDataProviderInterface
{
    /**
     * @return Product[]
     */
    public function get()
    {
        return Product::with(
            Product::RELATION_VOUCHERS,
            sprintf('%s.%s', Product::RELATION_VOUCHERS, Voucher::RELATION_DISCOUNT)
        )->where([
            ['is_active', '=', '1'],
            ['price', '>', '0'],
        ])->get();
    }
}
