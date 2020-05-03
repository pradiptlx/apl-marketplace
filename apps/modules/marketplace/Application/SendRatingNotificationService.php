<?php

namespace Dex\Marketplace\Application;

use Dex\Common\Events\DomainEvent;
use Dex\Common\Events\DomainEventSubscriber;
use Dex\Marketplace\Domain\Model\IdeaRated;
use Dex\Marketplace\Domain\Transport\MailerInterface;

class SendRatingNotificationService implements DomainEventSubscriber
{
    protected $mailer;

    public function __construct(MailerInterface $mailer)
    {
        $this->mailer = $mailer;
    }

    protected $subscribedTo = [
        IdeaRated::class
    ];

    public function name()
    {
        return "my name ahaha";
    }

    /**
     * @param DomainEvent $aDomainEvent
     */
    public function handle($aDomainEvent)
    {
        $this->mailer
            ->createMessage($aDomainEvent->email(), "noreply@idy.com", "Rating Notification", $aDomainEvent->rater() ." rated: " . $aDomainEvent->rating() . " for marketplace: " . $aDomainEvent->title())
            ->sendMessage();
    }

    /**
     * @param DomainEvent $aDomainEvent
     * @return bool
     */
    public function isSubscribedTo($aDomainEvent)
    {
        foreach ($this->subscribedTo as $subscribed)
        {
            if ($aDomainEvent instanceof $subscribed)
                return true;
        }
        return false;
    }
}
