<?php

namespace App\Web\Middleware;

use Throwable;
use Psr\Http\Server\RequestHandlerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use League\Route\Http\Exception\HttpExceptionInterface;

class HandlesRequests extends AbstractMiddleware
{
	/**
	 * Process an incoming server request.
	 *
	 * Processes an incoming server request in order to produce a response.
	 * If unable to produce the response itself, it may delegate to the provided
	 * request handler to do so.
	 *
	 * @param \Psr\Http\Message\ServerRequestInterface $request
	 * @param \Psr\Http\Server\RequestHandlerInterface $handler
	 *
	 * @return \Psr\Http\Message\ResponseInterface
	 */
	public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
	{
		try {
			$response = $handler->handle($request);
		} catch (HttpExceptionInterface $exc) {
			$response = $this->renderException($request, $exc);
		} catch (Throwable $exc) {
			$response = $this->renderException($request, $exc);
		}

		return $response;
	}
}
