<?php

namespace App\Resolution\Providers;

use League\Container\ContainerAwareInterface;
use Uweyv\Framework\Core\Application;
use Uweyv\Framework\Core\Contracts\ApplicationAwareInterface;

class AppProvider extends AbstractProvider
{
	/**
	 * Assign bindings on Provider registration.
	 *
	 * @return void
	 */
	public function register(): void
	{
		$this->container->share(Application::class, $this->app);

		$this->container
			->inflector(ApplicationAwareInterface::class)
			->invokeMethod('setApp', [Application::class]);

		$this->container
			->inflector(ContainerAwareInterface::class)
			->invokeMethod('setContainer', [$this->container]);
	}
}
