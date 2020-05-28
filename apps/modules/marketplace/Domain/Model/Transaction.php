<?php


namespace Dex\Marketplace\Domain\Model;

use Dex\Common\Events\DomainEventPublisher;
use Dex\Marketplace\Domain\Event\DecreaseProductCounterEvent;
use Dex\Marketplace\Domain\Event\IncreaseProductCounterEvent;
use Dex\Marketplace\Domain\Event\AfterTransactionEvent;
use Dex\Marketplace\Domain\Event\UpdateStatusTransactionEvent;
use Dex\Marketplace\Domain\Exception\InvalidIdModelException;

/**
 * Aggregate class Transaction
 * Class Transaction
 * @package Dex\Marketplace\Domain\Model
 */
class Transaction
{
    private TransactionId $id;
    private User $buyer;
    private ?Cart $cart;
    private PaymentMethodTransaction $paymentMethod;
    private string $statusTransaction;
    private string $createdAt;
    private ?string $updatedAt;

    public static string $FINISHED = "FINISHED";
    public static string $PENDING = "PENDING";
    public static string $FAILED = "FAILED";

    public function __construct(
        TransactionId $id,
        User $buyer,
        Cart $cart,
        PaymentMethodTransaction $paymentMethod,
        string $statusTransaction,
        string $created_at,
        string $updated_at = null
    )
    {
        $this->id = $id;
        $this->buyer = $buyer;
        $this->cart = $cart;
        $this->paymentMethod = $paymentMethod;
        $this->statusTransaction = $statusTransaction;
        $this->createdAt = $created_at;
        $this->updatedAt = $updated_at;
    }

    // Setelah melakukan use case transaction
    public function notifyPostTransaction()
    {
        switch ($this->statusTransaction) {
            case self::$FINISHED:
                DomainEventPublisher::instance()->publish(
                    new AfterTransactionEvent(
                        $this->paymentMethod,
                        $this->cart
                    )
                );
                return true;
                break;
            case self::$PENDING:
                // Jika jatuh tempo pembayaran lebih dari 2 hari, akan berubah menjadi FAILED
                try {
                    if (date_diff(new \DateTime($this->createdAt), new \DateTime()) > 2) {
                        DomainEventPublisher::instance()->publish(
                            new AfterTransactionEvent(
                                $this->paymentMethod,
                                $this->cart
                            )
                        );
                        // Update status gagal
                        DomainEventPublisher::instance()->publish(
                            new UpdateStatusTransactionEvent(
                                $this->id,
                                self::$FAILED
                            )
                        );

                    } else {
                        DomainEventPublisher::instance()->publish(
                            new DecreaseProductCounterEvent(
                                $this->cart->getProduct()->getId(),
                                $this->cart->getProduct()->getWishlistCounter(),
                                $this->cart->getProduct()->getStock(),
                                $this->cart->getProduct()->getCartCounter()
                            )
                        );

                    }
                } catch (\Exception $e) {
                    return new InvalidIdModelException($e->getMessage());
                }

                break;
            case self::$FAILED:
                DomainEventPublisher::instance()->publish(
                    new IncreaseProductCounterEvent(
                        $this->cart->getProduct()->getId(),
                        $this->cart->getProduct()->getWishlistCounter(),
                        $this->cart->getProduct()->getStock(),
                        $this->cart->getProduct()->getCartCounter()
                    )
                );
                break;
        }

        return false;
    }

    // Ketika buyer sudah menyerahkan bukti pembayaran dan valid
    public function notifyPostPayment()
    {
        if ($this->paymentMethod->isPaid()) {
            DomainEventPublisher::instance()->publish(
                new UpdateStatusTransactionEvent(
                    $this->id,
                    self::$FINISHED
                )
            );
        }

    }

    public function getId(): TransactionId
    {
        return $this->id;
    }

    public function getBuyer(): User
    {
        return $this->buyer;
    }

    public function getCart(): Cart
    {
        return $this->cart;
    }

    public function getPaymentMethod(): PaymentMethodTransaction
    {
        return $this->paymentMethod;
    }

    public function getStatusTransaction(): string
    {
        return $this->statusTransaction;
    }

    public function getCreatedDate(): string
    {
        return $this->createdAt;
    }

    public function getUpdatedDate(): ?string
    {
        return $this->updatedAt;
    }

}
