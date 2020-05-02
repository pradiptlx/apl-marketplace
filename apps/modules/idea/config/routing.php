<?php

$namespace = 'Idy\Idea\Presentation\Controllers\Web';
$module = 'idea';

$router->addGet('/idea/add', [
    'namespace' => $namespace,
    'module' => $module,
    'controller' => 'idea',
    'action' => 'addPage'
]);

$router->addPost('/idea/add', [
    'namespace' => $namespace,
    'module' => $module,
    'controller' => 'idea',
    'action' => 'add'
]);

$router->addPost('/idea/vote', [
    'namespace' => $namespace,
    'module' => $module,
    'controller' => 'idea',
    'action' => 'vote'
]);

$router->addPost('/idea/rate', [
    'namespace' => $namespace,
    'module' => $module,
    'controller' => 'idea',
    'action' => 'rate'
]);


return $router;
