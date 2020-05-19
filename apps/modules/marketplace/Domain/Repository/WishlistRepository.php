<?php


namespace Dex\Marketplace\Domain\Repository;


use Dex\Marketplace\Domain\Model\UserId;
use Dex\Marketplace\Domain\Model\Wishlist;

interface WishlistRepository
{
    public function byUserId(UserId $userId);

    public function saveWishlist(Wishlist $wishlist);

    public function deleteWishlist(string $id);

}
