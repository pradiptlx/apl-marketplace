<?php


namespace Dex\Marketplace\Domain\Model;


class Wishlist
{
    private string $id;
    private Product $product;
    private User $user;

    public function __construct(
        string $id,
        Product $product,
        User $user
    )
    {
        $this->id = $id;
        $this->product = $product;
        $this->user = $user;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getProduct(): Product
    {
        return $this->product;
    }

    public function getUser(): User
    {
        return $this->user;
    }

}
