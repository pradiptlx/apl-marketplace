<?php


namespace Dex\Marketplace\Application\ListItemsBuyer;


use Dex\Marketplace\Domain\Repository\ProductRepository;

class ListItemsBuyerService
{

    private ProductRepository $productRepository;

    public function __construct(ProductRepository $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    public function execute(): ListItemsBuyerResponse
    {
        $products = $this->productRepository->getAll();

        if (empty($products))
            return new ListItemsBuyerResponse(null, "Products Not Found", 200, false);

        return new ListItemsBuyerResponse($products, '', 200, false);
    }

}
