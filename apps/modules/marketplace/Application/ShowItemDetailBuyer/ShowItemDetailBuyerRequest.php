<?php


namespace Dex\Marketplace\Application\ShowItemDetailBuyer;


class ShowItemDetailBuyerRequest
{
    public string $productId;

    public function __construct(string $productId)
    {
        $this->productId = $productId;
    }

}
