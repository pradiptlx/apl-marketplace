<?php


namespace Dex\Marketplace\Domain\Repository;


use Dex\Marketplace\Domain\Model\Product;
use Dex\Marketplace\Domain\Model\ProductId;
use Dex\Marketplace\Domain\Model\UserId;

interface ProductRepository
{
    public function byId(ProductId $productId): ?Product;

    public function bySellerId(UserId $userId);

    public function getAll();

    public function saveProduct(Product $product);

    public function deleteProduct(ProductId $productId);

    public function editProduct(ProductId $productId);

}
