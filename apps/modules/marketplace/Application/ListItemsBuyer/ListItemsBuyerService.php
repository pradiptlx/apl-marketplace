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
            return new ListItemsBuyerResponse(null, "Products Not Found", 500, true);

        $datas = array('product' => $products);

        return new ListItemsBuyerResponse($datas, '', 200, false);
    }

}
