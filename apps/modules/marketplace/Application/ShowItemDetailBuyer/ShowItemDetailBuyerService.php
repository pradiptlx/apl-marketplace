<?php


namespace Dex\Marketplace\Application\ShowItemDetailBuyer;


use Dex\Marketplace\Domain\Model\ProductId;
use Dex\Marketplace\Domain\Repository\ProductRepository;
use Phalcon\Mvc\Model\Transaction\Failed;

class ShowItemDetailBuyerService
{
    private ProductRepository $productRepository;

    public function __construct(ProductRepository $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    public function execute(ShowItemDetailBuyerRequest $request): ShowItemDetailBuyerResponse
    {
        $productDetail = $this->productRepository->byId(new ProductId($request->productId));

        if($productDetail instanceof Failed)
            return new ShowItemDetailBuyerResponse($productDetail, $productDetail->getMessage(), 500, true);

        return new ShowItemDetailBuyerResponse($productDetail, '', 200, false);
    }

}
