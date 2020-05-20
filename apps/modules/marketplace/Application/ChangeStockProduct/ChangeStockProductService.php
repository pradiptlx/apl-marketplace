<?php


namespace Dex\Marketplace\Application\ChangeStockProduct;

use Dex\Marketplace\Application\ChangeProfileUser\ChangeProfileUserRequest;
use Dex\Marketplace\Domain\Model\ProductId;
use Dex\Marketplace\Domain\Model\UserId;
use Dex\Marketplace\Domain\Repository\ProductRepository;
use Phalcon\Mvc\Model\Transaction\Failed;

class ChangeStockProductService
{
    private ProductRepository $productRepository;

    public function __construct(ProductRepository $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    public function execute(ChangeStockProductRequest $request): ChangeStockProductResponse
    {
        $productDetail = $this->productRepository->changeStock(new ProductId($request->productId), $request->stock);

        if($productDetail instanceof Failed)
            return new ChangeStockProductResponse($productDetail, $productDetail->getMessage(), 500, true);

        return new ChangeStockProductResponse($productDetail, '', 200, false);
    }

}
