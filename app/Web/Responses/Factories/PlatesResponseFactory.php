<?php

namespace App\Web\Responses\Factories;

use GuzzleHttp\Psr7\Response;
use function GuzzleHttp\Psr7\stream_for;
use League\Plates\Engine;

class PlatesResponseFactory
{
	/**
	 * @var \League\Plates\Engine
	 */
	protected $engine;

	/**
	 * Construct an instance of PlatesResponseFactory.
	 *
	 * @param  \League\Plates\Engine  $engine
	 */
	public function __construct(Engine $engine)
	{
		$this->engine = $engine;
	}

	/**
	 * Create a PlatesResponse.
	 *
	 * @param string $template
	 *
	 * @return \App\Web\Responses\PlatesResponse
	 */
	public function create(string $template, array $data = [], array $attributes = [])
	{
		$body = $this->engine->render($template, $data, $attributes);

		$stream = stream_for($body);

		$response = new Response(200, [], $stream);

		return $response;
	}
}
