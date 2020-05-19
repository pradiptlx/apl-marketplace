<?php


namespace Dex\Marketplace\Application\SendNotificationTransactionBuyer;


use Dex\Common\Events\DomainEvent;
use Dex\Common\Events\DomainEventSubscriber;
use Dex\Marketplace\Domain\Model\Product;
use Dex\Marketplace\Domain\Model\User;
use Dex\Marketplace\Domain\Transport\MailerInterface;

class SendNotificationTransactionBuyerService implements DomainEventSubscriber
{
    private MailerInterface $mailer;

    public function __construct(MailerInterface $mailer)
    {
        $this->mailer = $mailer;
    }

    protected array $subscribedTo = [
        User::class,
        Product::class
    ];

    /**
     * @inheritDoc
     */
    public function handle($aDomainEvent)
    {
        if ($aDomainEvent instanceof User) {
            $this->mailer->createMessage(
                $aDomainEvent->getEmail(),
                "support@dex.test",
                'Hey ' . $aDomainEvent->getFullname(),
                'Your transaction is waiting. Finished it before product sold.'
            )
                ->sendMessage();
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
