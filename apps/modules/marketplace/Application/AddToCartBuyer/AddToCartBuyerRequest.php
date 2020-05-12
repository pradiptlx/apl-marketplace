<?php


namespace Dex\Marketplace\Application\AddToCartBuyer;


class AddToCartBuyerRequest
{
    public string $productId;
    public string $userId;

    public function __construct(
        string $productId,
        string $userId
    )
    {
        $this->productId = $productId;
        $this->userId = $userId;
    }

}
