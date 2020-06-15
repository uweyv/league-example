<?php

namespace App\Logging\Concerns\Monolog;

use Monolog\Logger;
use Monolog\Handler\StreamHandler;

trait CreatesFileHandlers
{
	protected function createFileHandler(array $config): StreamHandler
	{
		$file = $this->app->path($config['file']);
		$level = $config['level'] ?? Logger::NOTICE;
		$bubble = !!($config['bubble'] ?? true);
		$permission = $config['permission'] ?? null;
		$locking = !!($config['locking'] ?? false);

		$handler = new StreamHandler($file, $level, $bubble, $permission, $locking);

		return $handler;
	}
}
