<?php


namespace Dex\Marketplace\Domain\Model;


use Dex\Common\Events\DomainEventPublisher;
use Dex\Marketplace\Domain\Event\ChangeProductCounterEvent;

/**
 * Class Wishlist Aggregate
 * @package Dex\Marketplace\Domain\Model
 */
class Wishlist
{
    private WishlistId $id;
    private Product $product;
    private User $user;

    public function __construct(
        WishlistId $id,
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

    public function notifyProduct()
    {
        DomainEventPublisher::instance()->publish(
            new ChangeProductCounterEvent(
                $this->product->getId(),
                $this->product->getWishlistCounter(),
                $this->product->getStock()
            )
        );
    }

}
