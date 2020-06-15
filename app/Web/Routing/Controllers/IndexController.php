<?php

namespace App\Web\Routing\Controllers;

use Psr\Http\Message\ServerRequestInterface;

class IndexController extends AbstractController
{
	/**
	 * @param \Psr\Http\Message\ServerRequestInterface $request
	 */
	public function index(ServerRequestInterface $request)
	{
		return $this->responder->plates('pages/index');
	}
}
