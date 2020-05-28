<?php

use Dex\Common\Events\DomainEventPublisher;
use Dex\Marketplace\Application\DecreaseWishlistProductCounter\DecreaseWishlistProductCounterService;
use Dex\Marketplace\Application\DeleteCartUser\DeleteCartUserService;
use Dex\Marketplace\Application\IncrementWishlistProductCounter\IncrementWishlistProductCounterService;
use Dex\Marketplace\Application\SendNotificationTransactionBuyer\SendNotificationTransactionBuyerService;
use Dex\Marketplace\Application\UpdateStatusTransaction\UpdateStatusTransactionService;

DomainEventPublisher::instance()->subscribe(new IncrementWishlistProductCounterService(
    $di->get('sqlProductRepository')
));

DomainEventPublisher::instance()->subscribe(new SendNotificationTransactionBuyerService(
    $di->get('swiftMailer')
));

DomainEventPublisher::instance()->subscribe(new DecreaseWishlistProductCounterService(
    $di->get('sqlProductRepository')
));

DomainEventPublisher::instance()->subscribe(new DeleteCartUserService(
    $di->get('sqlCartRepository')
));

DomainEventPublisher::instance()->subscribe(new UpdateStatusTransactionService(
    $di->get('sqlTransactionRepository')
));

