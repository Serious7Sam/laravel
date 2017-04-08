<?php

namespace Tests\Unit\Entity;

use App\Entity\Discount;

class DiscountTest extends \PHPUnit_Framework_TestCase
{
    use EntityTestCaseTrait;

    public function testAccessors()
    {
        $discount = new Discount();
        $properties = [
            'id' => 2,
            'name' => 'test',
            'value' => 11.99,
        ];

        $this->assertPropertyAccessors($discount, $properties);
    }
}
