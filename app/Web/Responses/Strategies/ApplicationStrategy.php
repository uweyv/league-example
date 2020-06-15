<?php

namespace App\Web\Responses\Strategies;

use Throwable;
use Psr\Http\Server\MiddlewareInterface;
use League\Route\Strategy\ApplicationStrategy as BaseStrategy;
use App\Web\Middleware\HandlesExceptions;
use App\Web\Middleware\HandlesRequests;

class ApplicationStrategy extends BaseStrategy
{
	/**
	 * Return a middleware that simply throws an error
	 *
	 * @param \Throwable $error
	 *
	 * @return \Psr\Http\Server\MiddlewareInterface
	 */
	protected function throwThrowableMiddleware(Throwable $error): MiddlewareInterface
	{
		return $this->getContainer()->get(HandlesExceptions::class)
			->setException($error);
	}

	/**
	 * Get a middleware that acts as an exception handler, it should wrap the rest of the
	 * middleware stack and catch eny exceptions.
	 *
	 * @return \Psr\Http\Server\MiddlewareInterface
	 */
	public function getThrowableHandler(): MiddlewareInterface
	{
		return $this->getContainer()->get(HandlesRequests::class);
	}
}
