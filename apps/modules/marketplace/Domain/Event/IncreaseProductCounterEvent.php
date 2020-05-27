<?php


namespace Dex\Marketplace\Domain\Event;


use Dex\Common\Events\DomainEvent;
use Dex\Marketplace\Domain\Model\ProductId;

class IncreaseProductCounterEvent implements DomainEvent
{
    private ProductId $productId;
    private ?int $wishlist_counter;
    private ?int $stock_counter;
    private ?int $cart_counter;
    private \DateTimeImmutable $occurredOn;

    public function __construct(
        ProductId $productId,
        int $wishlist_counter = null,
        int $stock_counter = null,
        int $cart_counter = null
    )
    {
        $this->productId = $productId;
        $this->wishlist_counter = $wishlist_counter;
        $this->cart_counter = $cart_counter;
        $this->stock_counter = $stock_counter;
        $this->occurredOn = (new \DateTimeImmutable('now'));
    }

    public function getProductId(): ProductId
    {
        return $this->productId;
    }

    public function incWishlistCounter(): ?int
    {
        if (!isset($this->stock_counter))
            return null;
        return ++$this->wishlist_counter;
    }

    public function incStockCounter(): ?int
    {
        if (!isset($this->stock_counter))
            return null;
        return ++$this->stock_counter;
    }

    public function incCartCounter(): ?int
    {
        if (!isset($this->stock_counter))
            return null;
        return ++$this->cart_counter;
    }

    /**
     * @inheritDoc
     */
    public function occurredOn()
    {
        return $this->occurredOn();
    }
}
