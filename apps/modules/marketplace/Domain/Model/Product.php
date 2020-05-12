<?php


namespace Dex\Marketplace\Domain\Model;


class Product
{
    private ProductId $id;
    private string $productName;
    private string $description;
    private string $createdAt;
    private ?string $updatedAt;
    private int $stock;
    private string $price;
    private ?int $wishlistCounter;
    private ?User $seller;
    private ?UserId $sellerId;

    public function __construct(
        ProductId $id,
        string $productName,
        string $description,
        string $createdAt = "",
        string $updatedAt = "",
        int $stock = 0,
        string $price = "",
        int $wishlistCounter = 0,
        User $seller = null,
        UserId $sellerId = null
    )
    {
        $this->id = $id;
        $this->productName = $productName;
        $this->description = $description;
        $this->createdAt = $createdAt;
        $this->updatedAt = $updatedAt;
        $this->stock = $stock;
        $this->price = $price;
        $this->wishlistCounter = $wishlistCounter;
        $this->seller = $seller;
        $this->sellerId = $sellerId;
    }

    public function getId(): ProductId
    {
        return $this->id;
    }

    public function getProductName(): string
    {
        return $this->productName;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getCreatedDate(): string
    {
        return $this->createdAt;
    }

    public function getUpdatedDate(): ?string
    {
        return $this->updatedAt;
    }

    public function getStock(): int
    {
        return $this->stock;
    }

    public function getPrice(): string
    {
        return $this->price;
    }

    public function getWishlistCounter(): ?int
    {
        return $this->wishlistCounter;
    }

    public function getSeller(): User
    {
        return $this->seller;
    }

    public function getSellerId(): UserId
    {
        return $this->sellerId;
    }

    public function incStock(): int
    {
        return ++$this->stock;
    }

    public function decStock(): int
    {
        return --$this->stock;
    }

    public function incWishlistCounter(): int
    {
        return ++$this->wishlistCounter;
    }

    public function decWishlistCounter(): int
    {
        return --$this->wishlistCounter;
    }

}
