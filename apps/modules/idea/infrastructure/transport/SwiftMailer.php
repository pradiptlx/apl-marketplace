<?php


namespace Idy\Idea\Infrastructure\Transport;


use Idy\Idea\Domain\Transport\MailerInterface;
use Swift_Mailer;
use Swift_Message;

class SwiftMailer implements MailerInterface
{
    protected $mailer;
    protected $template;
    protected $message;

    public function __construct(Swift_Mailer $mailer)
    {
        $this->mailer = $mailer;
    }

    public function createMessage($to, $from, $subject, $body)
    {
        $message = (new Swift_Message($subject))
            ->setFrom([$from => $from])
            ->setTo([$to => $to])
            ->setBody($body, 'text/html');

        $this->message = $message;

        return $this;
    }

    public function sendMessage()
    {
        $this->mailer->send($this->message);
    }

    public function setTemplate($template)
    {
        $this->template = $template;

        return $this;
    }
}