<?php

namespace App\Resolution\Providers;

use Closure;
use Psr\Log\LoggerInterface;
use Psr\Log\LoggerAwareInterface;
use Uweyv\Framework\Logging\Contracts\DriverInterface;
use Uweyv\Framework\Support\Arr;
use App\Logging\Drivers;
use Uweyv\Framework\Exceptions\Contracts\ExceptionHandlerInterface;
use Uweyv\Framework\Exceptions\ExceptionHandler;

class LogProvider extends AbstractProvider
{
	protected $drivers = [
		'monolog' => Drivers\MonologDriver::class,
	];

	/**
	 * Register components to the application.
	 *
	 * @return void
	 */
	public function register(): void
	{
		$this->registerDrivers();
		$this->registerHandler();
	}

	/**
	 * Perform additional work.
	 *
	 * @return void
	 */
	public function boot(): void
	{
		$this->createLoggers();
		$this->installHandler();
	}

	protected function registerDrivers()
	{
		foreach ($this->drivers as $name => $driverClass) {
			if (is_subclass_of($driverClass, DriverInterface::class, true)) {
				$this->container->share($driverClass);
				$this->container->share($this->driver($name), $driverClass);
			}
		}
	}

	protected function registerHandler()
	{
		$this->container->share(ExceptionHandlerInterface::class, ExceptionHandler::class);
	}

	protected function createLoggers()
	{
		$config = $this->app->getConfig('log');

		$default = $config['default'] ?? null;
		$channels = $config['channels'] ?? [];

		foreach ($channels as $name => $cfg) {
			if (empty($default)) {
				$default = $name;
			}

			$driverName = $cfg['driver'] ?? null;

			$closure = Closure::fromCallable(function () use ($driverName, $name, $cfg) {
				$driver = $this->container->get($this->driver($driverName));
				return $driver->createLogger($name, Arr::except($cfg, ['driver']));
			});

			if ($name === $default) {
				$this->container->share(LoggerInterface::class, $closure);
				$this->container->share($this->channel(null), $closure);
			}

			$this->container->share($this->channel($name), $closure);
		}

		$this->container
			->inflector(LoggerAwareInterface::class)
			->invokeMethod('setLogger', [LoggerInterface::class]);
	}

	protected function installHandler()
	{
		$handler = $this->container->get(ExceptionHandlerInterface::class);

		$handler->install();
	}

	protected function driver(string $name): string
	{
		return sprintf('log.driver.%s', $name);
	}

	protected function channel(?string $name): string
	{
		return implode('.', array_filter(['log', $name]));
	}
}
