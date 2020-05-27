<?php


namespace Dex\Marketplace\Domain\Model;
use Dex\Common\Events\DomainEventPublisher;
use Dex\Marketplace\Domain\Event\DecreaseProductCounterEvent;
use Dex\Marketplace\Domain\Event\IncreaseProductCounterEvent;

class Cart
{
    private CartId $id;
    private ?Product $product;
    private ?User $buyer;
    private ?string $createdAt;

    public function __construct(
        CartId $id,
        Product $product,
        User $buyer,
        string $createdAt=""
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

    public function notifyProductToIncreaseCounter()
    {
        
        // // if(!$this->isStockFullfill()){
        // //     return false;
        // // }
        // else
        // {
        DomainEventPublisher::instance()->publish(
            new IncreaseProductCounterEvent(
                $this->product->getId(),
                $this->product->getWishlistCounter(),
                $this->product->getStock(),
                $this->product->getCartCounter(),
            )
        );
        // }
        
    }

    public function notifyProductToDecreaseCounter()
    {
        
        DomainEventPublisher::instance()->publish(
            new DecreaseProductCounterEvent(
                $this->product->getId(),
                $this->product->getWishlistCounter(),
                $this->product->getStock(),
                $this->product->getCartCounter(),
            )
        );
    }
}
