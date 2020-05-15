<?php

return array(
    'marketplace' => [
        'namespace' => 'Dex\Marketplace',
        'webControllerNamespace' => 'Dex\Marketplace\Presentation\Controllers\Web',
        'apiControllerNamespace' => 'Dex\Marketplace\Presentation\Controllers\Api',
        'className' => 'Dex\Marketplace\Module',
        'path' => APP_PATH . '/modules/marketplace/Module.php',
        'userDefinedRouting' => true,
        'defaultRouting' => true,
        'defaultController' => 'product',
        'defaultAction' => 'index',
    ],

);
