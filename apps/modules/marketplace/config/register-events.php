<?php

use Dex\Common\Events\DomainEventPublisher;
use Dex\Marketplace\Application\IncrementProductCounter\IncrementProductCounterService;

DomainEventPublisher::instance()->subscribe(new IncrementProductCounterService(
    $di->get('sqlProductRepository')
));


