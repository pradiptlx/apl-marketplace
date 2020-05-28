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

    public function statusComplete()
    {
        $this->statusTransaction = Transaction::$FINISHED;
    }

    public function statusFailed()
    {
        $this->statusTransaction = Transaction::$FAILED;
    }

    public function statusPending()
    {
        $this->statusTransaction = Transaction::$PENDING;
    }

    public function occurredOn()
    {
        return $this->occurredOn;
    }

}
