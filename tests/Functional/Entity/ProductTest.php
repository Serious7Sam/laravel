<?php

namespace Tests\Functional\Entity;

use App\Entity\Discount;
use App\Entity\Product;
use App\Entity\Voucher;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class ProductTest extends TestCase
{
    use DatabaseTransactions;

    public function testGetVouchers()
    {
        factory(Product::class)->create()->each(
            function(Product $product) {
                $product->vouchers()->sync(factory(Voucher::class, 2)->create());
            }
        );

        $product = Product::all()->first();
        $vouchers = $product->getVouchers();

        static::assertCount(2, $vouchers);
        static::assertInstanceOf(Voucher::class, $vouchers[0]);
    }

    public function testVouchersReturnsCorrectRelation()
    {
        $product = new Product();

        static::assertInstanceOf(BelongsToMany::class, $product->vouchers());
    }

    public function testGetPriceWithDiscountLowerMaxValue()
    {
        $product = $this->createProduct('Product 1', 54.78);

        $discount10 = $this->createDiscount(0.1);
        $discount20 = $this->createDiscount(0.2);

        $voucher10 = $this->createVoucher($discount10, true);
        $voucher20 = $this->createVoucher($discount20, true);
        $voucherNotActive = $this->createVoucher($discount20, false);

        $product->vouchers()->sync(new Collection([$voucher10, $voucher20, $voucherNotActive]));

        $expectedPrice = 1.3 * 54.78;

        static::assertSame($expectedPrice, $product->getPriceWithDiscount());
    }

    public function testGetPriceWithDiscountBiggerMaxValue()
    {
        $product = $this->createProduct('Product 1', 43.978);

        $discount50 = $this->createDiscount(0.5);
        $discount20 = $this->createDiscount(0.2);

        $voucher50 = $this->createVoucher($discount50, true);
        $voucher20 = $this->createVoucher($discount20, true);

        $product->vouchers()->sync(new Collection([$voucher50, $voucher20]));

        static::assertSame(1.6 * 43.978, $product->getPriceWithDiscount());
    }

    /**
     * @param string $name
     * @param float  $price
     *
     * @return Product
     */
    private function createProduct(string $name, float $price)
    {
        return factory(Product::class)->create([
            'name' => $name,
            'price' => $price,
            'is_active' => true,
        ]);
    }

    /**
     * @param float $value
     *
     * @return Discount
     */
    private function createDiscount(float $value)
    {
        return factory(Discount::class)->create([
            'name' => $value,
            'value' => $value,
        ]);
    }

    /**
     * @param Discount $discount
     * @param bool     $active
     *
     * @return Voucher
     */
    private function createVoucher(Discount $discount, bool $active)
    {
        return factory(Voucher::class)->create([
            'discount_id' => $discount->getId(),
            'start_date' => new \DateTime('now -1 day'),
            'end_date' => new \DateTime('now +1 day'),
            'is_active' => $active,
        ]);
    }
}
