<?php

namespace App\Logging\Concerns;

trait CreatesHandlers
{
	protected function createHandler(string $name, array $config)
	{
		$method = $this->getHandlerMethod($name);

		if (!method_exists($this, $method)) {
			return null;
		}

		return $this->$method($config);
	}

	protected function getHandlerMethod(string $handlerName)
	{
		return sprintf('create%sHandler', ucfirst($handlerName));
	}
}
