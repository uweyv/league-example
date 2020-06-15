<?php

$directory = dirname(__DIR__);

require_once "$directory/vendor/autoload.php";

/**
 * Set Up Configuration
 */
Dotenv\Dotenv::create($directory)->load();

$config = new Uweyv\Framework\Configuration\ConfigRepo("{$directory}/etc/config");

/**
 * Create the Container
 */
$container = new League\Container\Container();

$container->delegate(
	new League\Container\ReflectionContainer()
);

$container->share(Uweyv\Framework\Configuration\ConfigRepo::class, $config);

/**
 * Create the Application
 */
$app = (new Uweyv\Framework\Core\Application($directory))
	->setConfigRepo($config)
	->setContainer($container);

unset($directory);
unset($config);
unset($container);
