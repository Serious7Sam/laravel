<?php

namespace Tests\Functional\Http\Controllers\Api;

use App\Entity\Product;
use App\Entity\Voucher;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class ProductControllerTest extends TestCase
{
    const API_PREFIX = '/api/v1';

    use DatabaseTransactions;

    public function testStore()
    {
        $name = 'Product 1';
        $response = $this->postJson(self::API_PREFIX . '/product/', [
            'name' => $name,
            'price' => 92.46,
            'is_active' => true,
        ]);

        $response->assertStatus(201);

        $product = Product::all()->first();
        static::assertSame($name, $product->getName());

        $response = $this->postJson(self::API_PREFIX . '/product/', [
            'name' => 'Product 1',
            'price' => 92.46,
            'is_active' => true,
        ]);
        $response->assertStatus(400);
        $response->assertSee('Product already exists');
    }

    public function testDeleteVoucher()
    {
        /** @var Voucher $voucher */
        $voucher = factory(Voucher::class)->create();

        /** @var Product $product */
        $product = factory(Product::class)->create();
        $product->vouchers()->attach($voucher->getId());

        $response = $this->delete(
            sprintf('%s/product/voucher/%s/%s', self::API_PREFIX, $product->getId() + 1, $voucher->getId())
        );
        $response->assertStatus(400)
            ->assertSee('Product not found');

        $response = $this->delete(
            sprintf('%s/product/voucher/%s/%s', self::API_PREFIX, $product->getId(), $voucher->getId() + 1)
        );
        $response->assertStatus(400)
            ->assertSee('Voucher not found');

        $response = $this->delete(
            sprintf('%s/product/voucher/%s/%s', self::API_PREFIX, $product->getId(), $voucher->getId())
        );

        $response->assertStatus(200);

        $product = Product::all()->first();
        static::assertCount(0, $product->getVouchers());
    }

    public function testAddVoucher()
    {
        /** @var Voucher $voucher */
        $voucher = factory(Voucher::class)->create();

        /** @var Product $product */
        $product = factory(Product::class)->create();

        $response = $this->get(
            sprintf('%s/product/voucher/%s/%s', self::API_PREFIX, $product->getId() + 1, $voucher->getId())
        );
        $response->assertStatus(400)
            ->assertSee('Product not found');

        $response = $this->get(
            sprintf('%s/product/voucher/%s/%s', self::API_PREFIX, $product->getId(), $voucher->getId() + 1)
        );
        $response->assertStatus(400)
            ->assertSee('Voucher not found');

        $response = $this->get(
            sprintf('%s/product/voucher/%s/%s', self::API_PREFIX, $product->getId(), $voucher->getId())
        );

        $response->assertStatus(200);

        $product = Product::all()->first();
        $vouchers = $product->getVouchers();
        static::assertCount(1, $vouchers);
        static::assertSame($voucher->getId(), $vouchers[0]->getId());

        $response = $this->get(
            sprintf('%s/product/voucher/%s/%s', self::API_PREFIX, $product->getId(), $voucher->getId())
        );

        $response->assertStatus(400)
            ->assertSee('Voucher already added');
    }

    public function testBuy()
    {
        $vouchers = new Collection([
            $this->createVoucher(true),
            $this->createVoucher(true),
        ]);

        /** @var Product $product */
        $product = factory(Product::class)->create([
            'name' => 'test',
            'price' => 432,
            'is_active' => true,
        ]);
        $product->vouchers()->sync($vouchers);

        $response = $this->get(
            sprintf('%s/product/buy/%s/', self::API_PREFIX, $product->getId() + 1)
        );
        $response->assertStatus(400)
            ->assertSee('Product not found');

        $response = $this->get(
            sprintf('%s/product/buy/%s/', self::API_PREFIX, $product->getId())
        );
        $response->assertStatus(200);

        $product = Product::all()[0];
        $vouchers = $product->getVouchers();

        static::assertFalse($product->isActive());
        static::assertFalse($vouchers[0]->isActive());
        static::assertFalse($vouchers[1]->isActive());
    }

    /**
     * @param bool $active
     *
     * @return Voucher
     */
    private function createVoucher(bool $active)
    {
        return factory(Voucher::class)->create([
            'discount_id' => function() {
                return factory(\App\Entity\Discount::class)->create()->id;
            },
            'start_date' => new \DateTime('now -1 day'),
            'end_date' => new \DateTime('now +1 day'),
            'is_active' => $active,
        ]);
    }
}
