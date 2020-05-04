<?php

namespace Dex\Marketplace\Domain\Transport;

interface MailerInterface
{
    public function createMessage($to, $from, $subject, $body): self;

    public function sendMessage();

    public function setTemplate($template);
}
