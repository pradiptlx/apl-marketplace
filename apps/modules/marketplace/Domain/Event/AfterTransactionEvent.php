<?php


namespace Dex\Marketplace\Domain\Event;


use DateTimeImmutable;
use Dex\Common\Events\DomainEvent;
use Dex\Marketplace\Domain\Model\Cart;
use Dex\Marketplace\Domain\Model\PaymentMethodTransaction;
use Dex\Marketplace\Domain\Model\Product;

class AfterTransactionEvent implements DomainEvent
{

    private DateTimeImmutable $occurredOn;
    private PaymentMethodTransaction $paymentMethodTransaction;
    private Cart $cart;

    public function __construct(
        PaymentMethodTransaction $paymentMethodTransaction,
        Cart $cart
    )
    {
        $this->paymentMethodTransaction = $paymentMethodTransaction;
        $this->cart = $cart;
        $this->occurredOn = new DateTimeImmutable();
    }

    public function getPaymentMethod(): PaymentMethodTransaction
    {
        return $this->paymentMethodTransaction;
    }

    public function getCart(): Cart
    {
        return $this->cart;
    }

    /**
     * @inheritDoc
     */
    public function occurredOn()
    {
        return $this->occurredOn();
    }
}
