<?php

namespace App\Resolution\Providers;

use Uweyv\Framework\Resolution\Provider;
use Uweyv\Framework\Core\Application;

abstract class AbstractProvider extends Provider
{
	/**
	 * @var \League\Container\Container
	 */
	protected $container;

	/**
	 * Construct a Provider.
	 *
	 * @param \Uweyv\Framework\Core\Application $app
	 */
	public function __construct(Application $app)
	{
		parent::__construct($app);

		$this->container = $this->app->getContainer();
	}
}
