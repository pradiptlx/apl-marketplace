<?php


namespace Dex\Marketplace\Application\TransactionBuyer;


use Dex\Common\Events\DomainEvent;
use Dex\Common\Events\DomainEventSubscriber;
use Dex\Marketplace\Domain\Model\Product;
use Dex\Marketplace\Domain\Model\User;

class TransactionBuyerService implements DomainEventSubscriber
{

    protected array $subscribedTo = [
        User::class,
        Product::class
    ];
    /**
     * @inheritDoc
     */
    public function handle($aDomainEvent)
    {
        // TODO: Implement handle() method.
    }

    /**
     * @inheritDoc
     */
    public function isSubscribedTo($aDomainEvent)
    {
        // TODO: Implement isSubscribedTo() method.
    }
}
