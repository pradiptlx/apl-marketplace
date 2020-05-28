<?php

use Dex\Common\Events\DomainEventPublisher;
use Dex\Marketplace\Application\DecreaseWishlistProductCounter\DecreaseWishlistProductCounterService;
use Dex\Marketplace\Application\IncrementWishlistProductCounter\IncrementWishlistProductCounterService;
use Dex\Marketplace\Application\SendNotificationTransactionBuyer\SendNotificationTransactionBuyerService;

DomainEventPublisher::instance()->subscribe(new IncrementWishlistProductCounterService(
    $di->get('sqlProductRepository')
));

DomainEventPublisher::instance()->subscribe(new SendNotificationTransactionBuyerService(
    $di->get('swiftMailer')
));

DomainEventPublisher::instance()->subscribe(new DecreaseWishlistProductCounterService(
    $di->get('sqlProductRepository')
));

//TODO: REGISTER Transaction service
