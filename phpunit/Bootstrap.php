<?php
use Phalcon\DI;
use Phalcon\DI\FactoryDefault;

ini_set('display_errors',1);
error_reporting(E_ALL);
define('ROOT_PATH', __DIR__."../src/Searcher");

set_include_path(ROOT_PATH . PATH_SEPARATOR . get_include_path());

// Используем автозагрузчик приложений для автозагрузки классов.
// Автозагрузка зависимостей, найденных в composer.
$loader = new Phalcon\Loader();

$loader->registerDirs(array(
	ROOT_PATH
));

$loader->register();

$di = new FactoryDefault();
DI::reset();
DI::setDefault($di);