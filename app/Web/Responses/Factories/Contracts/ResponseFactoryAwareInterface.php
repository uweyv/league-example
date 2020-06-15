<?php

namespace App\Web\Responses\Factories\Contracts;

use App\Web\Responses\Factories\ResponseFactory;

interface ResponseFactoryAwareInterface
{
	/**
	 * Set the ResponseFactory interface.
	 *
	 * @param \App\Web\Responses\Factories\ResponseFactory $factory
	 */
	public function setResponseFactory(ResponseFactory $factory);
}
