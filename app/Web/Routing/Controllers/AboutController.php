<?php

namespace App\Web\Routing\Controllers;

use Psr\Http\Message\ServerRequestInterface;

class AboutController extends AbstractController
{
	/**
	 * @param \Psr\Http\Message\ServerRequestInterface $request
	 */
	public function index(ServerRequestInterface $request)
	{
		return $this->responder->plates('pages/about');
	}
}
