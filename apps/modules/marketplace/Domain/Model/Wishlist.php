<?php


namespace Dex\Marketplace\Domain\Model;


use Dex\Common\Events\DomainEventPublisher;
use Dex\Marketplace\Domain\Event\DecreaseProductCounterEvent;
use Dex\Marketplace\Domain\Event\IncreaseProductCounterEvent;

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

    public function notifyProductToIncreaseCounter()
    {
        
        if(!$this->isStockFullfill()){
            return false;
        }
        else
        {
            DomainEventPublisher::instance()->publish(
                new IncreaseProductCounterEvent(
                    $this->product->getId(),
                    $this->product->getWishlistCounter(),
                    $this->product->getStock()
                )
            );
        }
        
    }

    public function notifyProductToDecreaseCounter()
    {
        
        DomainEventPublisher::instance()->publish(
            new DecreaseProductCounterEvent(
                $this->product->getId(),
                $this->product->getWishlistCounter(),
                $this->product->getStock()
            )
        );
    }

    public function isStockFullfill()
    {
        if($this->product->getStock() <= 0)
        {
            return false;
        }
        elseif ($this->product->getStock() <= $this->product->getWishlistCounter())
        {
            return false;
        }
        elseif($this->product->getStock() > $this->product->getWishlistCounter())
        {
            return true;
        }
    }

}
