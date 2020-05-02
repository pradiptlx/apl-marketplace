<?php

use Phalcon\Config;

return new Config(
    [
        'database' => [
            'adapter' => getenv('MARKETPLACE_DB_ADAPTER'),
            'host' => getenv('MARKETPLACE_DB_HOST'),
            'username' => getenv('MARKETPLACE_DB_USERNAME'),
            'password' => getenv('MARKETPLACE_DB_PASSWORD'),
            'dbname' => getenv('MARKETPLACE_DB_NAME'),
        ],

        'mail' => [
            'driver' => getenv('MARKETPLACE_MAIL_DRIVER'),
            'cacheDir' => APP_PATH . "/cache/mail/",
            'fromName' => getenv('MARKETPLACE_MAIL_FROM_NAME'),
            'fromEmail' => getenv('MARKETPLACE_MAIL_FROM_EMAIL'),
            'smtp' => [
                'server'    => getenv('MARKETPLACE_MAIL_SMTP_HOST'),
                'port'      => getenv('MARKETPLACE_MAIL_SMTP_PORT'),
                'username'  => getenv('MARKETPLACE_MAIL_SMTP_USERNAME'),
                'password'  => getenv('MARKETPLACE_MAIL_SMTP_PASSWORD'),
            ],
        ],
    ]
);
