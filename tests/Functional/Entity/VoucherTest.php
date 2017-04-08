<?php

namespace Tests\Functional\Entity;

use App\Entity\Discount;
use App\Entity\Voucher;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class VoucherTest extends TestCase
{
    use DatabaseTransactions;

    public function testGetDiscount()
    {
        factory(Voucher::class)->create();

        $voucher = Voucher::all()->first();
        $discount = Discount::all()->first();

        static::assertEquals($discount, $voucher->getDiscount());
    }

    public function testDiscountReturnsCorrectRelation()
    {
        $voucher = new Voucher();

        static::assertInstanceOf(BelongsTo::class, $voucher->discount());
    }
}
