<?php

namespace Idy\Idea\Domain\Transport;

interface MailerInterface
{
    public function createMessage($to, $from, $subject, $body);
    public function sendMessage();
    public function setTemplate($template);
}