<?php

namespace Tests\Functional\Repository;

use App\Entity\Product;
use App\Repository\ModelManipulationRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class ModelManipulationRepositoryTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * @var ModelManipulationRepository
     */
    private $repository;

    protected function setUp()
    {
        parent::setUp();

        $this->repository = new ModelManipulationRepository();
    }

    public function testSave()
    {
        $name = 'test';
        $price = 43.3;

        $product = new Product();
        $product->setName($name)
            ->setPrice($price)
            ->setActive(true);

        $sameProduct = clone $product;

        static::assertTrue($this->repository->save($product));
        static::assertFalse($this->repository->save($sameProduct));

        /** @var Product $actualProduct */
        $actualProduct = Product::all()->first();
        static::assertSame($name, $actualProduct->getName());
        static::assertSame($price, $actualProduct->getPrice());
        static::assertTrue($actualProduct->isActive());
    }

    public function testDelete()
    {
        $product = factory(Product::class)->create();

        static::assertTrue($this->repository->delete($product));

        static::assertCount(0, Product::all());
    }
}
