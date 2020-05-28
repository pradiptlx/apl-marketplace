<?php


namespace Dex\Marketplace\Domain\Model;


class PaymentMethodTransaction
{
    private TransactionId $transactionId;
    private string $paymentMethod;
    private bool $active;
    private ?string $description;


    public function __construct(
        TransactionId $transactionId,
        string $paymentMethod,
        bool $active = true,
        string $description = null
    )
    {
        $this->transactionId = $transactionId;
        $this->paymentMethod = $paymentMethod;
        $this->active = $active;
        $this->description = $description;
    }

    public function isEqualToTransaction(TransactionId $id): bool
    {
        return $this->transactionId->getId() === $id->getId();
    }

    public function getMethod(): string
    {
        return $this->paymentMethod;
    }

    public function getStatus(): bool
    {
        return $this->active;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function changePaymentMethod(string $method)
    {
        $this->paymentMethod = $method;
    }

    public function changeStatus()
    {
        if ($this->active) {
            $this->active = false;
        } else {
            $this->active = true;
        }
    }

    public function setDescription(string $description)
    {
        $this->description = $description;
    }
}
