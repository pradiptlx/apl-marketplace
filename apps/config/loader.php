<?php

use Phalcon\Loader;

$loader = new Loader();

/**
  * Load library namespace
  */
$loader->registerNamespaces(array(
	/**
	 * Load SQL server db adapter namespace
	 */
	'Phalcon\Db\Adapter\Pdo' => APP_PATH . '/lib/Phalcon/Db/Adapter/Pdo/Sqlsrv',
	'Phalcon\Db\Dialect' => APP_PATH . '/lib/Phalcon/Db/Dialect/Sqlsrv',
	'Phalcon\Db\Result' => APP_PATH . '/lib/Phalcon/Db/Result/Sqlsrv',

	/**
	 * Load common classes
	 */
	'Dex\Common\Events' => APP_PATH . '/common/events',
));

$loader->register();
