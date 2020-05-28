<?php


namespace Dex\Marketplace\Application\UpdateStatusTransaction;


use Dex\Common\Events\DomainEventSubscriber;
use Dex\Marketplace\Domain\Event\UpdateStatusTransactionEvent;
use Dex\Marketplace\Domain\Repository\TransactionRepository;

class UpdateStatusTransactionService implements DomainEventSubscriber
{

    private TransactionRepository $transactionRepository;

    public function __construct(TransactionRepository $transactionRepository)
    {
        $this->transactionRepository = $transactionRepository;
    }

    protected array $subscribedTo = [
        UpdateStatusTransactionEvent::class
    ];

    /**
     * @inheritDoc
     */
    public function handle($aDomainEvent)
    {
        if($aDomainEvent instanceof UpdateStatusTransactionEvent){
            $datas = [
                'updated_at' => (new \DateTime())->format('Y-m-d H:i:s'),
                'status_transaction' => $aDomainEvent->getNewStatusTransaction()
            ];

            $this->transactionRepository->update($datas, $aDomainEvent->getTransactionId());
        }
    }

    /**
     * @inheritDoc
     */
    public function isSubscribedTo($aDomainEvent)
    {
        foreach ($this->subscribedTo as $subscribed) {
            if ($aDomainEvent instanceof $subscribed)
                return true;
        }
        return false;
    }
}
