<?php

use Dex\Marketplace\Infrastructure\Transport\SwiftMailer;
use Phalcon\Config;
use Phalcon\Escaper;
use Phalcon\Events\Event;
use Phalcon\Events\Manager;
use Phalcon\Mvc\View\Engine\Volt;
use Phalcon\Mvc\ViewInterface;
use Phalcon\Url;
use Phalcon\Session\Manager as SessionManager;
use Phalcon\Session\Adapter\Stream as SessionAdapter;
use Phalcon\Http\Response\Cookies;
use Phalcon\Security;
use Phalcon\Mvc\Dispatcher;
use Phalcon\Mvc\View;
use Phalcon\Flash\Direct as Flash;
use Phalcon\Flash\Session as FlashSession;

/**
 * @var Phalcon\Config $config
 *
 * @return Config
 */
$di['config'] = function () use ($config) {
    return $config;
};

/**
 * Start the session the first time some component request the session service
 */
$di->setShared('session', function () {
    $session = new SessionManager();
    $files = new SessionAdapter([
        'savePath' => sys_get_temp_dir(),
    ]);
    $session->setAdapter($files);
    $session->start();

    return $session;
});

/**
 * @var string $defaultModule
 *
 * @return Dispatcher
 */
$di['dispatcher'] = function () use ($di, $defaultModule) {

    $eventsManager = new Manager();

    $eventsManager->attach(
        'dispatch:beforeException',
        function (Event $event, $dispatcher, Exception $exception) {
            // 404
            if ($exception instanceof \Phalcon\Mvc\Dispatcher\Exception) {
                $dispatcher->forward(
                    [
                        'controller' => 'index',
                        'action' => 'fourOhFour',
                    ]
                );

            }
            return false;
        }
    );

    $dispatcher = new Dispatcher();
    $dispatcher->setEventsManager($eventsManager);

    return $dispatcher;
};

$di['url'] = function () use ($config, $di) {
    $url = new Url();

    $url->setBaseUri($config->url['baseUrl']);

    return $url;
};

$di['voltService'] = function (ViewInterface $view) use ($di, $config) {
    $volt = new Volt($view, $di);
    if (!is_dir($config->application->cacheDir)) {
        mkdir($config->application->cacheDir);
    }

    $compileAlways = $config->mode == 'DEVELOPMENT';

    $volt->setOptions(array(
        'always' => $compileAlways,
        'extension' => '.php',
        'separator' => '_',
        'stat' => true,
        'path' => $config->application->cacheDir,
        'prefix' => '-prefix-',
    ));
    return $volt;
};

$di['view'] = function () {
    $view = new View();
    $view->setViewsDir(APP_PATH . '/common/views/');

    $view->registerEngines(
        [
            ".volt" => "voltService",
        ]
    );

    return $view;
};

$di->set(
    'security',
    function () {
        $security = new Security();
        $security->setWorkFactor(12);

        return $security;
    },
    true
);

/**
 * Register the session flash service with the Twitter Bootstrap classes
 */
$di->set('flash', function () {
    $escaper = new Escaper();
    $flash = new Flash($escaper);

    $flash->setCssClasses([
        'error' => 'alert alert-danger alert-dismissible fade show',
        'success' => 'alert alert-success alert-dismissible fade show',
        'notice' => 'alert alert-info alert-dismissible fade show',
        'warning' => 'alert alert-warning alert-dismissible fade show'
    ]);

    return $flash;
});


/**
 * Change Flash session css Classes
 */
$di->set('flashSession', function () {
    $escaper = new Escaper();
    $flash = new FlashSession($escaper);
    $flash->setCssClasses([
        'error' => 'alert alert-danger alert-dismissible fade show',
        'success' => 'alert alert-success alert-dismissible fade show',
        'notice' => 'alert alert-info alert-dismissible fade show',
        'warning' => 'alert alert-warning alert-dismissible fade show'
    ]);

    return $flash;
});
