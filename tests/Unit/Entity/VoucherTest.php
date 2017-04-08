<?php

namespace Tests\Unit\Entity;

use App\Entity\Voucher;

class VoucherTest extends \PHPUnit_Framework_TestCase
{
    use EntityTestCaseTrait;

    public function testAccessors()
    {
        $voucher = new Voucher();
        $properties = [
            'id' => 2,
            'startDate' => new \DateTime(),
            'endDate' => new \DateTime(),
            'active' => true,
        ];

        $this->assertPropertyAccessors($voucher, $properties);
    }

    public function testIsApplicableNotActive()
    {
        $voucher = new Voucher();
        $voucher->setActive(false);

        static::assertFalse($voucher->isApplicable());
    }

    public function testIsApplicableWrongDate()
    {
        $voucher = new Voucher();
        $voucher->setActive(true);
        $voucher->setStartDate(new \DateTime('now +1 day'));
        $voucher->setEndDate(new \DateTime('now +2 day'));

        static::assertFalse($voucher->isApplicable());
    }

    public function testIsApplicableTrue()
    {
        $voucher = new Voucher();
        $voucher->setActive(true);
        $voucher->setStartDate(new \DateTime('now -1 day'));
        $voucher->setEndDate(new \DateTime('now +2 day'));

        static::assertTrue($voucher->isApplicable());
    }
}
