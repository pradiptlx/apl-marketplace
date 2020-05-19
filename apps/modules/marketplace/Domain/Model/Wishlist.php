<?php


namespace Dex\Marketplace\Domain\Model;


use Dex\Common\Events\DomainEvent;
use Dex\Common\Events\DomainEventPublisher;

class Wishlist implements DomainEvent
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

        DomainEventPublisher::instance()->publish(
            new Product(
                $product->getId(),
                $product->getProductName(),
                $product->getDescription(),
                $product->getCreatedDate(),
                $product->getUpdatedDate(),
                $product->getStock(),
                $product->getPrice(),
                $product->incWishlistCounter(),
                $product->getImagePath(),
                $product->getSeller()
            )
        );
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

    public function occurredOn()
    {
        // TODO: Implement occurredOn() method.
    }
}
