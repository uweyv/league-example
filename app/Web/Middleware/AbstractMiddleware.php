<?php

namespace App\Web\Middleware;

use Throwable;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use League\Route\Http\Exception\HttpExceptionInterface;
use App\Web\Responses\Factories\Concerns\IssuesResponse;
use App\Web\Responses\Factories\Contracts\ResponseFactoryAwareInterface;

abstract class AbstractMiddleware implements MiddlewareInterface, ResponseFactoryAwareInterface
{
	use IssuesResponse;

	protected function renderException(ServerRequestInterface $request, Throwable $exc): ResponseInterface
	{
		$statusCode = 500;

		$headers = [];

		$data = [
			'exception' => $exc,
		];

		if ($exc instanceof HttpExceptionInterface) {
			$statusCode = $exc->getStatusCode();
			$headers = $exc->getHeaders();
		}

		$accept = $request->getHeaderLine('Accept');

		if (stripos($accept, 'application/json') !== false) {
			$response = $this->responder->json([
				'errors' => [
					[
						'code' => $statusCode,
					],
				],
			]);
		} else {
			$template = sprintf('errors/%u', $statusCode);

			if (isset($template)) {
				$response = $this->responder->plates($template, $data);
			}
		}

		if (!isset($response)) {
			throw $exc;
		}

		$response = $response->withStatus($statusCode);

		foreach ($headers as $header => $value) {
			$response = $response->withAddedHeader($header, $value);
		}

		return $response;
	}
}
