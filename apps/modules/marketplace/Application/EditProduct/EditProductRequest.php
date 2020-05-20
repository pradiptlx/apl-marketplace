<?php


namespace Dex\Marketplace\Application\EditProduct;


class EditProductRequest
{
    public string $productId;
    public array $datas;

    public function __construct(string $productId, array $datas)
    {
        $this->productId = $productId;
        $this->datas = $datas;
    }

}
