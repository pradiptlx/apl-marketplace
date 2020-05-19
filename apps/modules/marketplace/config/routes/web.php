<?php
use Phalcon\Mvc\Router;

/**
 * @var Router $router
 * @var array $module
 * @var string $moduleName
 */

$router->add(
    '/user',
    [
        'namespace' => $module['webControllerNamespace'],
        'module' => 'marketplace',
        'controller' => 'user',
        'action' => 'login'
    ]
);

$router->add(
    '/seller',
    [
    'namespace' => $module['webControllerNamespace'],
    'module' => 'marketplace',
    'controller' => 'seller',
    'action' => 'index'
    ]
);

