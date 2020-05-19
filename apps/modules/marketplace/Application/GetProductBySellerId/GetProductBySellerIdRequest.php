<?php


namespace Dex\Marketplace\Application\GetProductBySellerId;


class GetProductBySellerIdRequest
{
    public string $sellerId;

    public function __construct(string $sellerId)
    {
        $this->sellerId = $sellerId;
    }

}
