<?php


namespace Dex\Marketplace\Application\DeleteItemOnWishlist;


use Dex\Marketplace\Domain\Repository\WishlistRepository;

class DeleteItemOnWishlistService
{
    private WishlistRepository $wishlistRepository;

    public function __construct(WishlistRepository $wishlistRepository)
    {
        $this->wishlistRepository = $wishlistRepository;
    }

}
