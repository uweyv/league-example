<?php

namespace App\Web\Responses\Factories\Concerns;

use App\Web\Responses\Factories\ResponseFactory;

trait IssuesResponse
{
	/**
	 * ResponseFactory instance.
	 *
	 * @var \App\Web\Responses\Factories\ResponseFactory
	 */
	protected ResponseFactory $responder;

	/**
	 * Set the ResponseFactory interface.
	 *
	 * @param \App\Web\Responses\Factories\ResponseFactory $factory
	 *
	 * @return $this
	 */
	public function setResponseFactory(ResponseFactory $factory)
	{
		$this->responder = $factory;

		return $this;
	}
}
