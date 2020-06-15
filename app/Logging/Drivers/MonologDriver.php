<?php

namespace App\Logging\Drivers;

use Psr\Log\LoggerInterface;
use Monolog\Logger;
use Uweyv\Framework\Support\Arr;
use Uweyv\Framework\Core\Concerns\UsesApplication;
use Uweyv\Framework\Core\Contracts\ApplicationAwareInterface;
use App\Logging\Concerns\CreatesHandlers;
use App\Logging\Concerns\Monolog\CreatesFileHandlers;

class MonologDriver extends AbstractDriver implements ApplicationAwareInterface
{
	use UsesApplication;
	use CreatesHandlers;
	use CreatesFileHandlers;

	/**
	 * Create a Logger instance.
	 *
	 * @param string $name
	 * @param array $config
	 *
	 * @return LoggerInterface
	 */
	public function createLogger(string $name, array $config): LoggerInterface
	{
		$logger = new Logger($name);

		$handlerConfigs = $config['handlers'] ?? [];

		foreach ($handlerConfigs as $handlerConfig) {
			$type = $handlerConfig['type'] ?? null;

			if (!empty($type)) {
				$cfg = Arr::except($handlerConfig, ['type']);

				$handler = $this->createHandler($type, $cfg);

				if (!empty($handler)) {
					$logger->pushHandler($handler);
				}
			}
		}

		return $logger;
	}
}
