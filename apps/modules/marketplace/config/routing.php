<?php

$namespace = 'Dex\Marketplace\Presentation\Controllers\Web';
$module = 'marketplace';

/** @var Phalcon\Mvc\Router $router */
$router->addGet('/marketplace/add', [
    'namespace' => $namespace,
    'module' => $module,
    'controller' => 'marketplace',
    'action' => 'addPage'
]);

$router->addPost('/marketplace/add', [
    'namespace' => $namespace,
    'module' => $module,
    'controller' => 'marketplace',
    'action' => 'add'
]);

$router->addPost('/marketplace/vote', [
    'namespace' => $namespace,
    'module' => $module,
    'controller' => 'marketplace',
    'action' => 'vote'
]);

$router->addPost('/marketplace/rate', [
    'namespace' => $namespace,
    'module' => $module,
    'controller' => 'marketplace',
    'action' => 'rate'
]);


return $router;
