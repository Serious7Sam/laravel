<?php

namespace App\Http\Controllers\Main;

use App\DataProvider\Product\ProductsDataProviderInterface;
use App\Entity\Product;
use App\Http\Controllers\Controller;

class IndexController extends Controller
{
    /**
     * @var Product[]
     */
    private $products;

    /**
     * @param ProductsDataProviderInterface $productsProvider
     */
    public function __construct(ProductsDataProviderInterface $productsProvider)
    {
        $this->products = $productsProvider->get();
    }

    public function index()
    {
        return view('page.index', [
            'products' => $this->products,
        ]);
    }
}
