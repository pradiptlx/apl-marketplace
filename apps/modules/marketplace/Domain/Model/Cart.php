<?php


namespace Dex\Marketplace\Domain\Model;


class Cart
{
    private CartId $id;
    private ?Product $product;
    private ?User $buyer;
    private ?string $createdAt;

    public function __construct(
        CartId $id,
        Product $product = null,
        User $buyer = null,
        string $createdAt = null
    )
    {
        $this->id = $id;
        $this->product = $product;
        $this->buyer = $buyer;
        $this->createdAt = $createdAt;
    }


    public function getId(): CartId
    {
        return $this->id;
    }

    public function getProduct(): ?Product
    {
        return $this->product;
    }

    public function getBuyer(): ?User
    {
        return $this->buyer;
    }

    public function getCreatedDate(): ?string
    {
        return $this->createdAt;
    }
}
