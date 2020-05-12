<?php


namespace Dex\Marketplace\Application\AddItemToWishlistBuyer;


use Dex\Marketplace\Domain\Model\Cart;
use Dex\Marketplace\Domain\Model\CartId;
use Dex\Marketplace\Domain\Model\ProductId;
use Dex\Marketplace\Domain\Model\UserId;
use Dex\Marketplace\Domain\Model\Wishlist;
use Dex\Marketplace\Domain\Repository\WishlistRepository;
use Dex\Marketplace\Domain\Repository\ProductRepository;
use Dex\Marketplace\Domain\Repository\UserRepository;
use Phalcon\Mvc\Model\Transaction\Failed;
use Ramsey\Uuid\Uuid;

class AddItemToWishlistBuyerService
{
    private WishlistRepository $wishlistRepository;
    private ProductRepository $productRepository;
    private UserRepository $userRepository;

    public function __construct(WishlistRepository $wishlistRepository, ProductRepository $productRepository, UserRepository $userRepository)
    {
        $this->wishlistRepository = $wishlistRepository;
        $this->productRepository = $productRepository;
        $this->userRepository = $userRepository;
    }

    public function execute(AddItemToWishlistBuyerRequest $request): AddItemToWishlistBuyerResponse
    {
        $productId = new ProductId($request->productId);
        $userId = new UserId($request->userId);

        $response = $this->wishlistRepository->saveWishlist(
            new Wishlist(
                Uuid::uuid4()->toString(),
                $this->productRepository->byId($productId),
                $this->userRepository->byId($userId)
            )
        );

        if ($response instanceof Failed)
            return new AddItemToWishlistBuyerResponse($response, $response->getMessage(), 500, true);

        return new AddItemToWishlistBuyerResponse($response, "Add to Wishlist Success", 200, false);
    }

}
