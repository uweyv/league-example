<?php

namespace App\Web\Routing\Controllers;

class ContactController extends AbstractController
{
	public function index()
	{
		return $this->responder->plates('pages/contact/index');
	}

	public function create()
	{
		
	}
}
