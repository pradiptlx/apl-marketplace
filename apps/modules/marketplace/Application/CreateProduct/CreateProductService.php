<?php


namespace Dex\Marketplace\Application\CreateProduct;

use Dex\Marketplace\Domain\Model\Product;
use Dex\Marketplace\Domain\Model\ProductId;
use Dex\Marketplace\Domain\Model\UserId;
use Dex\Marketplace\Domain\Repository\ProductRepository;
use Dex\Marketplace\Domain\Repository\UserRepository;
use Phalcon\Mvc\Model\Transaction\Failed;

class CreateProductService
{
    private ProductRepository $productRepository;
    private UserRepository $userRepository;

    public function __construct(ProductRepository $productRepository, UserRepository $userRepository)
    {
        $this->productRepository = $productRepository;
        $this->userRepository = $userRepository;
    }

    public function execute(CreateProductRequest $request): CreateProductResponse
    {
        $userId = new UserId($request->getSeller_id());
        $response = $this->productRepository->saveProduct(
            new Product(
                new ProductId(),
                $request->getProductName(),
                $request->getDescription(),
                "",
                "",
                $request->getStock(),
                $request->getPrice(),
                0,
                $this->userRepository->byId($userId),
                $userId
            )
        );

        if ($response instanceof Failed)
            return new CreateProductResponse($response, $response->getMessage(), 500, true);

        return new CreateProductResponse($response, "Create Product Success", 200, false);
    }
}
