<?php


namespace Dex\Marketplace\Application\DeleteProduct;


class DeleteProductRequest
{
    public string $productId;

    public function __construct(string $productId)
    {
        $this->productId = $productId;
    }

}
