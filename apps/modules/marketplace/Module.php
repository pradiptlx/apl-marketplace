<?php

namespace Dex\Marketplace;

use Phalcon\Di\DiInterface;
use Phalcon\Loader;
use Phalcon\Mvc\ModuleDefinitionInterface;

class Module implements ModuleDefinitionInterface
{
    public function registerAutoloaders(DiInterface $di = null)
    {
        $loader = new Loader();

        $loader->registerNamespaces([
            'Dex\Marketplace\Domain\Model' => __DIR__ . '/Domain/Model',
            'Dex\Marketplace\Domain\Repository' => __DIR__ . '/Domain/Repository',
            'Dex\Marketplace\Domain\Transport' => __DIR__ . '/Domain/Transport',
            'Dex\Marketplace\Domain\Exception' => __DIR__ . '/Domain/Exception',
            'Dex\Marketplace\Infrastructure\Persistence' => __DIR__ . '/Infrastructure/Persistence',
            'Dex\Marketplace\Infrastructure\Persistence\Record' => __DIR__ . '/Infrastructure/Persistence/Record',
            'Dex\Marketplace\Infrastructure\Transport' => __DIR__ . '/Infrastructure/Transport',
            'Dex\Marketplace\Application' => __DIR__ . '/Application',
            'Dex\Marketplace\Presentation\Controllers\Web' => __DIR__ . '/Presentation/Controllers/Web',
            'Dex\Marketplace\Presentation\Controllers\Api' => __DIR__ . '/Presentation/Controllers/Api',
            'Dex\Marketplace\Presentation\Controllers\Validators' => __DIR__ . '/Presentation/Controllers/Validators',
        ]);

        $loader->register();
    }

    public function registerServices(DiInterface $di = null)
    {
        $moduleConfig = require __DIR__ . '/config/config.php';

        $di->get('config')->merge($moduleConfig);

        include_once __DIR__ . '/config/services.php';
        include_once  __DIR__ . '/config/register-events.php';
    }

}
