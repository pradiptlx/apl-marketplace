<?php


namespace Dex\Marketplace\Application\DeleteCartUser;


use Dex\Common\Events\DomainEventSubscriber;
use Dex\Marketplace\Domain\Event\AfterTransactionEvent;
use Dex\Marketplace\Domain\Repository\CartRepository;

class DeleteCartUserService implements DomainEventSubscriber
{
    private CartRepository $cartRepository;

    public function __construct(CartRepository $cartRepository)
    {
        $this->cartRepository = $cartRepository;
    }

    protected array $subscribedTo = [
        AfterTransactionEvent::class
    ];

    /**
     * @inheritDoc
     */
    public function handle($aDomainEvent)
    {
        if ($aDomainEvent instanceof AfterTransactionEvent) {
            $response = $this->cartRepository->deleteCart($aDomainEvent->getCart()->getId());
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
