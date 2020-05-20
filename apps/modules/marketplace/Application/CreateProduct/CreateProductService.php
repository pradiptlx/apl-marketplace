<?php


namespace Dex\Marketplace\Application\CreateProduct;

use Dex\Marketplace\Domain\Exception\InvalidActionFileException;
use Dex\Marketplace\Domain\Model\Product;
use Dex\Marketplace\Domain\Model\ProductId;
use Dex\Marketplace\Domain\Model\ProductImage;
use Dex\Marketplace\Domain\Model\UserId;
use Dex\Marketplace\Domain\Repository\ProductRepository;
use Dex\Marketplace\Domain\Repository\UserRepository;
use Phalcon\Http\Request\File;
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
        $productId = new ProductId();
        $productImages = null;

        if (isset($request->files)) {
            $path = $request->getSeller_id() . '/' . $request->getProductName() . '/';
            /**
             * @var File $file
             */
            foreach ($request->files as $file) {
                $productImages[] = new ProductImage(
                    $productId,
                    $path,
                    $file->getName(),
                    new \DateTime('now')
                );
            }
        }

        $product = new Product(
            $productId,
            $request->getProductName(),
            $request->getDescription(),
            new \DateTime('now'),
            new \DateTime('now'),
            $request->getStock(),
            $request->getPrice(),
            0,
            $productImages,
            $this->userRepository->byId($userId),
            $userId
        );
        $response = $this->productRepository->saveProduct(
            $product
        );

        if ($response instanceof Failed)
            return new CreateProductResponse($response, $response->getMessage(), 500, true);

        //TODO: Alternative pakai Files milik Phalcon saja
        // If save success, move files
        if (isset($productImages)) {
            foreach ($productImages as $productImage) {
                $statusFile = $productImage->saveImage();
                if($statusFile instanceof InvalidActionFileException)
                    return new CreateProductResponse($statusFile, $statusFile->getMessage(), 500, true);
            }
        }

        return new CreateProductResponse($response, "Create Product Success", 200, false);
    }
}
