<?php

use Idy\Common\Events\DomainEventPublisher;
use Idy\Idea\Application\SendRatingNotificationService;

DomainEventPublisher::instance()->subscribe(new SendRatingNotificationService($di->get('swiftMailer')));