<?php

namespace App\Resolution\Providers;

use App\Extensions\Plates\ComposerExtension;
use Psr\Http\Server\RequestHandlerInterface;
use Psr\Http\Message\ServerRequestInterface;
use GuzzleHttp\Psr7\ServerRequest;
use League\Route\Router;
use League\Plates\Engine;
use Uweyv\Framework\Web\Emission\Emitter;
use App\Web\Routing\RequestHandler;
use App\Web\Responses\Strategies\ApplicationStrategy;
use App\Web\Responses\Factories\Contracts\ResponseFactoryAwareInterface;
use App\Web\Responses\Factories\ResponseFactory;
use Uweyv\Framework\Exceptions\Contracts\ExceptionHandlerInterface;

class WebProvider extends AbstractProvider
{
	/**
	 * Assign bindings on Provider registration.
	 *
	 * @return void
	 */
	public function register() : void
	{
		$this->registerRequests();
		$this->registerRouter();
		$this->registerResponses();
	}

	/**
	 * Perform operations on Application boot.
	 *
	 * @return void
	 */
	public function boot() : void
	{
		$this->bootRoutes();
		$this->bootEmitters();
	}

	/**
	 * Set up resolution of the ServerRequest.
	 */
	protected function registerRequests()
	{
		$request = ServerRequest::fromGlobals();

		$this->container
			->share(ServerRequestInterface::class, $request)
			->addTag('request');

		$this->container
			->share(ServerRequest::class, $request);
	}

	/**
	 * Set up resolution of the Router.
	 */
	protected function registerRouter()
	{
		$strategy = new ApplicationStrategy();

		$strategy->setContainer($this->container);

		$router = (new Router())
			->setStrategy($strategy);

		$this->container
			->share(Router::class, $router)
			->addTag('router');

		$this->container
			->share(RequestHandlerInterface::class, $router);
	}

	/**
	 * Set up resolution of Responses.
	 */
	protected function registerResponses()
	{
		$config = $this->app->getConfig('web');

		// Plates Engine
		$platesConfig = $config['plates'] ?? [];

		if (isset($platesConfig['base_dir'])) {
			$platesConfig['base_dir'] = $this->app->path($platesConfig['base_dir']);
		}

		$plates = Engine::createWithConfig($platesConfig);

//		$assetsExt = new Asset($this->app->path('public'), false);

		$this->container
			->add(ComposerExtension::class)
			->addMethodCall('setConfig', [$config])
			->setShared(true);

		$composers = $this->container->get(ComposerExtension::class);

		$plates->register($composers);

		$this->container
			->share(Engine::class, $plates)
			->addTag('plates');

		// ResponseFactory
		$this->container
			->inflector(ResponseFactoryAwareInterface::class)
			->invokeMethod('setResponseFactory', [ResponseFactory::class]);
	}

	/**
	 * Set up the routing tables.
	 */
	protected function bootRoutes()
	{
		$config = $this->app->getConfig('web');

		$router = $this->container->get(Router::class);

		foreach ($config['routes'] as $scheme => $file) {
			require_once $this->app->path($file . '.php');
		}
	}

	/**
	 * Set up the response emitter.
	 */
	protected function bootEmitters()
	{
		$config = $this->app->getConfig('web');

		$this->container->share(Emitter::class);

		$emitter = $this->container->get(Emitter::class);

		foreach ($config['emitters'] as $emitterClass) {
			$strategy = $this->container->get($emitterClass);
			$emitter->addStrategy($strategy);
		}
	}
}
