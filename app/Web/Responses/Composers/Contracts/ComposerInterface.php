<?php

namespace App\Web\Responses\Composers\Contracts;

use League\Plates\Template;

interface ComposerInterface
{
	/**
	 * Set the data for the Composer to pass to the Template.
	 *
	 * @param array $data
	 */
	public function setData(array $data);

	/**
	 * Compose the Template.
	 *
	 * @param \League\Plates\Template $template
	 *
	 * @return \League\Plates\Template
	 */
	public function compose(Template $template): Template;
}
