<?php

namespace App\Http\Controllers\Api;

use App\Entity\Product;
use App\Entity\Voucher;
use App\Factory\ProductFactoryInterface;
use App\Http\Controllers\Controller;
use App\Repository\ModelManipulationRepositoryInterface;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ProductController extends Controller
{
    /**
     * @var ProductFactoryInterface
     */
    private $productFactory;

    /**
     * @var ModelManipulationRepositoryInterface
     */
    private $modelRepository;

    /**
     * @param ProductFactoryInterface              $productFactory
     * @param ModelManipulationRepositoryInterface $modelRepository
     */
    public function __construct(
        ProductFactoryInterface $productFactory,
        ModelManipulationRepositoryInterface $modelRepository
    ) {
        $this->productFactory = $productFactory;
        $this->modelRepository = $modelRepository;
    }

    /**
     * @param Request $request
     *
     * @return Response
     */
    public function store(Request $request)
    {
        $name = $request->input('name');
        $price = (float) $request->input('price');
        $active = (bool) $request->input('is_active');

        $product = $this->productFactory->create($name, $price, $active);

        if (!$this->modelRepository->save($product)) {
            return response('Product already exists', 400);
        }

        return response($product, 201);
    }

    /**
     * @param int $productId
     * @param int $voucherId
     *
     * @return Response
     */
    public function deleteVoucher($productId, $voucherId)
    {
        $product = Product::find($productId);
        if (!$product) {
            return response('Product not found', 400);
        }

        $voucher = Voucher::find($voucherId);
        if (!$voucher) {
            return response('Voucher not found', 400);
        }

        $product->vouchers()->detach($voucherId);

        return response('ok', 200);
    }

    /**
     * @param int $productId
     * @param int $voucherId
     *
     * @return Response
     */
    public function addVoucher($productId, $voucherId)
    {
        /** @var Product $product */
        $product = Product::find($productId);
        if (!$product) {
            return response('Product not found', 400);
        }

        $voucher = Voucher::find($voucherId);
        if (!$voucher) {
            return response('Voucher not found', 400);
        }

        try {
            $product->vouchers()->attach($voucherId);
        } catch (QueryException $e) {
            return response('Voucher is added', 400);
        }

        return response('ok', 200);
    }

    /**
     * @param int $id
     *
     * @return Response
     */
    public function buy($id)
    {
        /** @var Product $product */
        $product = Product::find($id);
        if (!$product) {
            return response('Product not found', 400);
        }

        $product->setActive(false);

        if (!$product->save()) {
            return response('Error', 400);
        }

        $product->vouchers()->update(['is_active' => 0]);

        return response('ok', 200);
    }
}
