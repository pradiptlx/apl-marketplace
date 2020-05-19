<?php


namespace Dex\Marketplace\Application\SearchProduct;


use Dex\Marketplace\Domain\Repository\ProductRepository;

class SearchProductService
{
    private ProductRepository $productRepository;

    public function __construct(ProductRepository $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    public function execute(SearchProductRequest $request): SearchProductResponse
    {
        $res = $this->productRepository->searchProduct($request->keyword);

        return new SearchProductResponse($res, "Search Result", 200, false);
    }

}
