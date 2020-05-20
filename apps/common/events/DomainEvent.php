<?php

namespace Dex\Common\Events;

use DateTimeImmutable;

interface DomainEvent
{
    /**
    * @return DateTimeImmutable
    */
    public function occurredOn();
}
