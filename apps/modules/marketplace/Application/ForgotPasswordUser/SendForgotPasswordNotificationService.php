<?php


namespace Dex\Marketplace\Application\ForgotPasswordUser;

use Dex\Marketplace\Domain\Model\User;
use Dex\Marketplace\Domain\Transport\MailerInterface;

class SendForgotPasswordNotificationService
{
    protected MailerInterface $mailer;

    public function __construct(MailerInterface $mailer)
    {
        $this->mailer = $mailer;
    }


    public function handle(User $user, string $from, string $token)
    {
        $this->mailer->createMessage($user->getEmail(), $from,
            'User ' . $user->getFullname() . ' request to change the password',
            'This token is one time used only ' . $token)
            ->sendMessage();

        return true;
    }

    public static function createMailerService(MailerInterface $mailer)
    {
        return new self($mailer);
    }


}
