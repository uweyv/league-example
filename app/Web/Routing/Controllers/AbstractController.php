<?php

namespace App\Web\Routing\Controllers;

use Psr\Log\LoggerInterface;
use App\Web\Responses\Factories\Contracts\ResponseFactoryAwareInterface;
use App\Web\Responses\Factories\Concerns\IssuesResponse;

class AbstractController implements ResponseFactoryAwareInterface
{
	use IssuesResponse;

	protected LoggerInterface $log;

	public function __construct(LoggerInterface $log)
	{
		$this->log = $log;
	}
}
