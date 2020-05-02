<?php

namespace Idy\Idea;

use Phalcon\DiInterface;
use Phalcon\Loader;
use Phalcon\Mvc\ModuleDefinitionInterface;

class Module implements ModuleDefinitionInterface
{
    public function registerAutoloaders(DiInterface $di = null)
    {
        $loader = new Loader();

        $loader->registerNamespaces([
            'Idy\Idea\Domain\Model' => __DIR__ . '/domain/model',
            'Idy\Idea\Domain\Repository' => __DIR__ . '/domain/repository',
            'Idy\Idea\Domain\Transport' => __DIR__ . '/domain/transport',
            'Idy\Idea\Domain\Exception' => __DIR__ . '/domain/exception',
            'Idy\Idea\Infrastructure\Persistence' => __DIR__ . '/infrastructure/persistence',
            'Idy\Idea\Infrastructure\Transport' => __DIR__ . '/infrastructure/transport',
            'Idy\Idea\Application' => __DIR__ . '/application',
            'Idy\Idea\Presentation\Controllers\Web' => __DIR__ . '/presentation/controllers/web',
            'Idy\Idea\Presentation\Controllers\Api' => __DIR__ . '/presentation/controllers/api',
            'Idy\Idea\Presentation\Controllers\Validators' => __DIR__ . '/presentation/controllers/validators',
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