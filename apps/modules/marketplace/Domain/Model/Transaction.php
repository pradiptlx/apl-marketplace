<?php


namespace Dex\Marketplace\Domain\Model;

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

    public function isTransactionFinished(): bool{
        switch ($this->statusTransaction){
            case self::$FINISHED:
                //TODO: Event remove cart counter
                return true;
                break;
            case self::$PENDING:
                //TODO: SEND EMAIL NOTIFICATION
                break;
            case self::$FAILED:
                //TODO: SEND EMAIL
                break;
        }

        return false;
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
