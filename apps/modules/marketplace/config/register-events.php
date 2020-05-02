<?php

use Dex\Common\Events\DomainEventPublisher;
use Dex\Marketplace\Application\SendRatingNotificationService;

DomainEventPublisher::instance()->subscribe(new SendRatingNotificationService($di->get('swiftMailer')));
