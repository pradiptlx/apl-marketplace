<?php


namespace Dex\Marketplace\Domain\Event;


use DateTimeImmutable;
use Dex\Common\Events\DomainEvent;
use Dex\Marketplace\Domain\Model\Transaction;
use Dex\Marketplace\Domain\Model\TransactionId;

class UpdateStatusTransactionEvent implements DomainEvent
{
    private DateTimeImmutable $occurredOn;
    private TransactionId $transactionId;
    private string $statusTransaction;

    public function __construct(
        TransactionId $transactionId,
        string $statusTransaction
    )
    {
        $this->transactionId = $transactionId;
        $this->statusTransaction = $statusTransaction;

        $this->occurredOn = new DateTimeImmutable('now');
    }

    public function isEqualToTransaction(TransactionId $transactionId): bool
    {
        return $this->transactionId->getId() === $transactionId->getId();
    }

    public function getTransactionId(): TransactionId
    {
        return $this->transactionId;
    }

    public function getNewStatusTransaction()
    {
        $this->statusTransaction;
    }

    public function occurredOn()
    {
        return $this->occurredOn;
    }

}
