<?php


namespace Dex\Marketplace\Application\DeleteItemOnWishlist;


class DeleteItemOnWishlistRequest
{
    public string $wishlistId;

    public function __construct(string $wishlistId)
    {
        $this->wishlistId = $wishlistId;
    }


}
