<?php

use Dex\Common\Events\DomainEventPublisher;
use Dex\Marketplace\Application\IncrementProductCounter\IncrementProductCounterService;
use Dex\Marketplace\Application\SendNotificationTransactionBuyer\SendNotificationTransactionBuyerService;

DomainEventPublisher::instance()->subscribe(new IncrementProductCounterService(
    $di->get('sqlProductRepository')
));

DomainEventPublisher::instance()->subscribe(new SendNotificationTransactionBuyerService(
    $di->get('swiftMailer')
));

