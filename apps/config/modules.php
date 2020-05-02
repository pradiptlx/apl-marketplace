<?php

return array(
    'idea' => [
        'namespace' => 'Idy\Idea',
        'webControllerNamespace' => 'Idy\Idea\Presentation\Controllers\Web',
        'apiControllerNamespace' => 'Idy\Idea\Presentation\Controllers\Api',
        'className' => 'Idy\Idea\Module',
        'path' => APP_PATH . '/modules/idea/Module.php',
        'userDefinedRouting' => true,
        'defaultRouting' => true,
        'defaultController' => 'idea',
        'defaultAction' => 'index',
    ],

);