<?php


namespace Dex\Marketplace\Application\GetProductBySellerId;


use Dex\Marketplace\Domain\Model\ProductId;
use Dex\Marketplace\Domain\Model\UserId;
use Dex\Marketplace\Domain\Repository\ProductRepository;
use Phalcon\Mvc\Model\Transaction\Failed;

class GetProductBySellerIdService
{
    private ProductRepository $productRepository;

    public function __construct(ProductRepository $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    public function execute(GetProductBySellerIdRequest $request): GetProductBySellerIdResponse
    {
        $productDetail = $this->productRepository->bySellerId(new UserId($request->sellerId));

        if($productDetail instanceof Failed)
            return new GetProductBySellerIdResponse($productDetail, $productDetail->getMessage(), 500, true);

        $datas = array('product' => $productDetail);

        return new GetProductBySellerIdResponse($datas, '', 200, false);
    }

}
