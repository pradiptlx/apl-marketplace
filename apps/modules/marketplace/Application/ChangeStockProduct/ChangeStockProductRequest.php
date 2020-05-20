<?php


namespace Dex\Marketplace\Application\ChangeStockProduct;


class ChangeStockProductRequest
{
    public string $productId;
    public int $stock;

    public function __construct(string $productId, int $stock)
    {
        $this->productId = $productId;
        $this->stock = $stock;
    }

}
