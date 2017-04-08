<?php

use Illuminate\Database\Seeder;
use App\Entity\Product;
use App\Entity\Voucher;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        factory(Product::class, 10)->create()->each(
            function(Product $product) {
                $product->vouchers()->sync(factory(Voucher::class, 5)->create());
            }
        );
    }
}
