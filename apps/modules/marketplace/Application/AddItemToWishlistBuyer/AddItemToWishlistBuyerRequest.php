<?php


namespace Dex\Marketplace\Application\AddItemToWishlistBuyer;


class AddItemToWishlistBuyerRequest
{
    public string $productId;
    public string $userId;

    public function __construct(string $productId, string $userId)
    {
        $this->productId = $productId;
        $this->userId = $userId;
    }

}
