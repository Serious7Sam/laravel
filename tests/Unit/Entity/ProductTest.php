<?php

namespace Tests\Unit\Entity;

use App\Entity\Product;

class ProductTest extends \PHPUnit_Framework_TestCase
{
    use EntityTestCaseTrait;

    public function testAccessors()
    {
        $product = new Product();
        $properties = [
            'id' => 2,
            'name' => 'test',
            'price' => 11.99,
            'active' => true,
        ];

        $this->assertPropertyAccessors($product, $properties);
    }
}
