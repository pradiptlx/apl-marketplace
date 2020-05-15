<?php

use Dex\Marketplace\Application\AddItemToWishlistBuyer\AddItemToWishlistBuyerService;
use Dex\Marketplace\Application\CreateUserAccount\CreateUserAccountService;
use Dex\Marketplace\Application\ListItemsBuyer\ListItemsBuyerService;
use Dex\Marketplace\Application\ShowItemDetailBuyer\ShowItemDetailBuyerService;
use Dex\Marketplace\Infrastructure\Persistence\SqlCartRepository;
use Dex\Marketplace\Infrastructure\Persistence\SqlProductRepository;
use Dex\Marketplace\Infrastructure\Persistence\SqlUserRepository;
use Dex\Marketplace\Infrastructure\Persistence\SqlWishlistRepository;
use Dex\Marketplace\Infrastructure\Transport\SwiftMailer;
use Phalcon\Mvc\View;
use Phalcon\Mvc\View\Engine\Volt;

$di['voltServiceMail'] = function($view) use ($di) {

    $config = $di->get('config');

    $volt = new Volt($view, $di);
    if (!is_dir($config->mail->cacheDir)) {
        mkdir($config->mail->cacheDir);
    }

    $compileAlways = $config->mode == 'DEVELOPMENT';

    $volt->setOptions(array(
        'always' => $compileAlways,
        'extension' => '.php',
        'separator' => '_',
        'stat' => true,
        'path' => $config->application->cacheDir,
    ));
    return $volt;
};

$di['view'] = function () {
    $view = new View();
    $view->setViewsDir(__DIR__ . '/../views/');

    $view->registerEngines(
        [
            ".volt" => "voltService",
        ]
    );

    return $view;
};

$di['db'] = function () use ($di) {

    $config = $di->get('config');

    $dbAdapter = $config->database->adapter;

    return new $dbAdapter([
        "host" => $config->database->host,
        "username" => $config->database->username,
        "password" => $config->database->password,
        "dbname" => $config->database->dbname
    ]);
};


$di->set('swiftMailerTransport', function ()  use ($di) {
    $config = $di->get('config');
    return (new Swift_SmtpTransport($config->mail->smtp->server, $config->mail->smtp->port))
        ->setUsername($config->mail->smtp->username)
        ->setPassword($config->mail->smtp->password);
});

$di->set('swiftMailer', function () use ($di) {
    $mailer = new Swift_Mailer($di->get('swiftMailerTransport'));

    return new SwiftMailer($mailer);
});

/**
 * SQL
 */
$di->set('sqlUserRepository', function (){
    return new SqlUserRepository();
});

$di->set('sqlProductRepository', function (){
    return new SqlProductRepository();
});

$di->set('sqlCartRepository', function (){
    return new SqlCartRepository();
});

$di->set('sqlWishlistRepository', function (){
    return new SqlWishlistRepository();
});

/**
 * SERVICE
 */

$di->set('addItemToWishlistBuyerService', function () use($di){
    return new AddItemToWishlistBuyerService(
        $di->get('sqlWishlistRepository'),
        $di->get('sqlProductRepository'),
        $di->get('sqlUserRepository')
    );
});

$di->set('addToCartBuyerService', function () use($di){
    return new AddItemToWishlistBuyerService(
        $di->get('sqlCartRepository'),
        $di->get('sqlProductRepository'),
        $di->get('sqlUserRepository')
    );
});

$di->set('showItemDetailBuyerService', function () use($di){
    return new ShowItemDetailBuyerService(
        $di->get('sqlProductRepository')
    );
});

$di->set('listItemsBuyerService', function () use($di){
    return new ListItemsBuyerService(
        $di->get('sqlProductRepository')
    );
});

$di->set('createUserAccountService', function () use($di){
    return new CreateUserAccountService(
        $di->get('sqlUserRepository')
    );
});

