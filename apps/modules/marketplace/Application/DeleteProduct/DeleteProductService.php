<?php


namespace Dex\Marketplace\Application\DeleteProduct;


use Dex\Marketplace\Domain\Model\ProductId;
use Dex\Marketplace\Domain\Model\UserId;
use Dex\Marketplace\Domain\Repository\ProductRepository;
use Phalcon\Mvc\Model\Transaction\Failed;

class DeleteProductService
{
    private ProductRepository $productRepository;

    public function __construct(ProductRepository $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    public function execute(DeleteProductRequest $request): DeleteProductResponse
    {
        $productDetail = $this->productRepository->deleteProduct(new ProductId($request->productId));

        if($productDetail instanceof Failed)
            return new DeleteProductResponse($productDetail, $productDetail->getMessage(), 500, true);

        return new DeleteProductResponse($productDetail, '', 200, false);
    }

}
