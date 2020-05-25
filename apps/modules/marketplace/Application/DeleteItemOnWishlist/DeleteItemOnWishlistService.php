<?php


namespace Dex\Marketplace\Application\DeleteItemOnWishlist;


use Dex\Marketplace\Domain\Model\Wishlist;
use Dex\Marketplace\Domain\Model\WishlistId;
use Dex\Marketplace\Domain\Repository\ProductRepository;
use Dex\Marketplace\Domain\Repository\WishlistRepository;
use Phalcon\Mvc\Model\Transaction\Failed;

class DeleteItemOnWishlistService
{
    private WishlistRepository $wishlistRepository;

    public function __construct(WishlistRepository $wishlistRepository)
    {
        $this->wishlistRepository = $wishlistRepository;
    }

    public function execute(DeleteItemOnWishlistRequest $request): DeleteItemOnWishlistResponse
    {
        // wishlistId is string
        $wishlistId = new WishlistId($request->wishlistId);
        /**
         * @var Wishlist $wishlist
         */
        $wishlist = $this->wishlistRepository->byId($wishlistId);
        $response = $this->wishlistRepository->deleteWishlist($wishlistId);

        if ($response instanceof Failed)
            return new DeleteItemOnWishlistResponse($response, $response->getMessage(), 500, true);

        // Call product event
        $wishlist->notifyProductToDecreaseCounter();

        return new DeleteItemOnWishlistResponse(null, "Done", 200, false);
    }

}
