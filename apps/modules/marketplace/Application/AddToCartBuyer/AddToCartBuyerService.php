<?php


namespace Dex\Marketplace\Application\AddToCartBuyer;


use Dex\Marketplace\Domain\Model\Cart;
use Dex\Marketplace\Domain\Model\CartId;
use Dex\Marketplace\Domain\Model\ProductId;
use Dex\Marketplace\Domain\Model\UserId;
use Dex\Marketplace\Domain\Repository\CartRepository;
use Dex\Marketplace\Domain\Repository\ProductRepository;
use Dex\Marketplace\Domain\Repository\UserRepository;
use Phalcon\Mvc\Model\Transaction\Failed;

class AddToCartBuyerService
{
    private CartRepository $cartRepository;
    private ProductRepository $productRepository;
    private UserRepository $userRepository;

    public function __construct(CartRepository $cartRepository, ProductRepository $productRepository, UserRepository $userRepository)
    {
        $this->cartRepository = $cartRepository;
        $this->productRepository = $productRepository;
        $this->userRepository = $userRepository;
    }

    public function execute(AddToCartBuyerRequest $request): AddToCartBuyerResponse
    {
        $productId = new ProductId($request->productId);
        $userId = new UserId($request->userId);

        $response = $this->cartRepository->saveCart(
            new Cart(
                new CartId(),
                $this->productRepository->byId($productId),
                $this->userRepository->byId($userId),
                new \DateTime('now')
            )
        );

        if ($response instanceof Failed)
            return new AddToCartBuyerResponse($response, $response->getMessage(), 500, true);

        return new AddToCartBuyerResponse($response, "Add to Wishlist Success", 200, false);
    }
}
