<?php


namespace Dex\Marketplace\Infrastructure\Persistence;


use Dex\Marketplace\Domain\Model\UserId;
use Dex\Marketplace\Domain\Model\Wishlist;
use Dex\Marketplace\Domain\Repository\WishlistRepository;

class SqlWishlistRepository implements WishlistRepository
{

    public function byUserId(UserId $userId): ?Wishlist
    {
        // TODO: Implement byUserId() method.
    }

    public function saveWishlist(Wishlist $wishlist)
    {
        // TODO: Implement saveWishlist() method.
    }

    public function deleteWishlist(string $id)
    {
        // TODO: Implement deleteWishlist() method.
    }
}
