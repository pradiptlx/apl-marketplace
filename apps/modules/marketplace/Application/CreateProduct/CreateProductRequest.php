<?php


namespace Dex\Marketplace\Application\CreateProduct;

use Dex\Marketplace\Domain\Model\User;

class CreateProductRequest
{
    protected string $productName;
    protected int $stock;
    protected string $description;
    protected string $price;
    protected string $seller_id;

    public function __construct(
        string $seller_id,
        string $price,
        string $description,
        int $stock,
        string $productName
    )
    {
        $this->seller_id = $seller_id;
        $this->price = $price;
        $this->description = $description;
        $this->stock = $stock;
        $this->productName = $productName;
    }

    public function getSeller_id(): string
    {
        return $this->seller_id;
    }

    public function getPrice(): string
    {
        return $this->price;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getStock(): int
    {
        return $this->stock;
    }

    public function getProductName(): string
    {
        return $this->productName;
    }

}
