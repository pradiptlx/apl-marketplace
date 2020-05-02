<?php

namespace Idy\Idea\Application;

use Idy\Common\Events\DomainEvent;
use Idy\Common\Events\DomainEventSubscriber;
use Idy\Idea\Domain\Model\IdeaRated;
use Idy\Idea\Domain\Transport\MailerInterface;

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
            ->createMessage($aDomainEvent->email(), "noreply@idy.com", "Rating Notification", $aDomainEvent->rater() ." rated: " . $aDomainEvent->rating() . " for idea: " . $aDomainEvent->title())
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