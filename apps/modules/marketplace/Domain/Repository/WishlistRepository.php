<?php


namespace Dex\Marketplace\Domain\Repository;


use Dex\Marketplace\Domain\Model\UserId;
use Dex\Marketplace\Domain\Model\Wishlist;
use Dex\Marketplace\Domain\Model\WishlistId;

interface WishlistRepository
{
    public function byId(WishlistId $wishlistId);

    public function byUserId(UserId $userId);

    public function saveWishlist(Wishlist $wishlist);

    public function deleteWishlist(WishlistId $id);

}
