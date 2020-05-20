<?php


namespace Dex\Marketplace\Application\EditProduct;


use Dex\Marketplace\Domain\Model\ProductId;
use Dex\Marketplace\Domain\Model\UserId;
use Dex\Marketplace\Domain\Repository\ProductRepository;
use Phalcon\Mvc\Model\Transaction\Failed;

class EditProductService
{
    private ProductRepository $productRepository;

    public function __construct(ProductRepository $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    public function execute(EditProductRequest $request): EditProductResponse
    {
        $productDetail = $this->productRepository->editProduct($request->datas ,new ProductId($request->productId));

        if($productDetail instanceof Failed)
            return new EditProductResponse($productDetail, $productDetail->getMessage(), 500, true);

        return new EditProductResponse($productDetail, '', 200, false);
    }

}
