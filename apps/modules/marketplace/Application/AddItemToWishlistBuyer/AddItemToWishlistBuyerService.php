<?php


namespace Dex\Marketplace\Application\AddItemToWishlistBuyer;


use Dex\Marketplace\Domain\Model\Cart;
use Dex\Marketplace\Domain\Model\CartId;
use Dex\Marketplace\Domain\Model\ProductId;
use Dex\Marketplace\Domain\Model\UserId;
use Dex\Marketplace\Domain\Model\Wishlist;
use Dex\Marketplace\Domain\Model\WishlistId;
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

        $wishlist = new Wishlist(
            new WishlistId(),
            $this->productRepository->byId($productId),
            $this->userRepository->byId($userId)
        );
        $response = $this->wishlistRepository->saveWishlist(
            $wishlist
        );

        if ($response instanceof Failed)
            return new AddItemToWishlistBuyerResponse($response, $response->getMessage(), 500, true);

        // Send Event to Change Wishlist Product Counter
        if($wishlist->notifyProductToIncreaseCounter()){
            return new AddItemToWishlistBuyerResponse($response, "Add to Wishlist Success", 200, false);
        }
        else{
            return new AddItemToWishlistBuyerResponse($response, "Stock is not fulfill", 500, true);
        }

        
    }

}
