<?php

namespace App\Web\Responses\Factories;

use GuzzleHttp\Psr7\Response;
use Uweyv\Framework\Support\Json;

class ResponseFactory
{
	/**
	 * @var \App\Core\Web\Responses\Factories\PlatesResponseFactory
	 */
	protected $plates;

	/**
	 * Construct an instance of ResponseFactory.
	 *
	 * @param \App\Core\Web\Responses\Factories\PlatesResponseFactory $plates
	 */
	public function __construct(PlatesResponseFactory $plates)
	{
		$this->plates = $plates;
	}

	/**
	 * Create a Response.
	 *
	 * @param string|null|resource|\Psr\Http\Message\StreamInterface $body
	 *
	 * @return \GuzzleHttp\Psr7\Response
	 */
	public function respond($body)
	{
		// int $status = 200, array $headers = [], ?string $body = null, ?string $version = '1.1', ?string $reason = null
		return new Response(200, [], $body);
	}

	/**
	 * Create a Response with a JSON body.
	 *
	 * @param array $body
	 *
	 * @return void
	 */
	public function json(array $body)
	{
		$headers = [
			'Content-Type' => 'application/json',
		];

		return new Response(200, $headers, Json::encode($body));
	}

	/**
	 * Create a Response with a rendered Plates Template body.
	 *
	 * @param string $template
	 * @param array $data
	 *
	 * @return \GuzzleHttp\Psr7\Response
	 */
	public function plates(string $template, array $data = [])
	{
		return $this->plates->create($template, $data);
	}
}
