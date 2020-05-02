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
            'Dex\Marketplace\Domain\Model' => __DIR__ . '/domain/model',
            'Dex\Marketplace\Domain\Repository' => __DIR__ . '/domain/repository',
            'Dex\Marketplace\Domain\Transport' => __DIR__ . '/domain/transport',
            'Dex\Marketplace\Domain\Exception' => __DIR__ . '/domain/exception',
            'Dex\Marketplace\Infrastructure\Persistence' => __DIR__ . '/infrastructure/persistence',
            'Dex\Marketplace\Infrastructure\Transport' => __DIR__ . '/infrastructure/transport',
            'Dex\Marketplace\Application' => __DIR__ . '/application',
            'Dex\Marketplace\Presentation\Controllers\Web' => __DIR__ . '/presentation/controllers/web',
            'Dex\Marketplace\Presentation\Controllers\Api' => __DIR__ . '/presentation/controllers/api',
            'Dex\Marketplace\Presentation\Controllers\Validators' => __DIR__ . '/presentation/controllers/validators',
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
