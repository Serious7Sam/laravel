<?php

namespace Tests\Functional\Http\Controllers\Main;

use App\Entity\Product;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class IndexControllerTest extends TestCase
{
    use DatabaseTransactions;

    public function testIndex()
    {
        /** @var Product $product */
        $product = factory(Product::class)->create([
            'name' => 'Test',
            'price' => 11.48,
            'is_active' => true,
        ]);

        $response = $this->get('/');

        $response->assertStatus(200)
            ->assertSee($product->getName())
            ->assertSee((string) $product->getPrice());
    }
}
