<?php

namespace App\Web\Responses\Composers;

use League\Plates\Template;
use App\Web\Responses\Composers\Contracts\ComposerInterface;

abstract class AbstractComposer implements ComposerInterface
{
	/**
	 * The data for the Composer to pass to the Template.
	 */
	protected array $data = [];

	/**
	 * Magic method to handle invocation of the Composer as a function.
	 *
	 * @param Template $template
	 *
	 * @return \League\Plates\Template
	 */
	public function __invoke(Template $template): Template
	{
		return $this->compose($template);
	}

	/**
	 * Set the data for the Composer to pass to the Template.
	 *
	 * @param array $data
	 *
	 * @return $this
	 */
	public function setData(array $data)
	{
		$this->data = $data;

		return $this;
	}
}
