<?php

namespace App\Web\Responses\Composers;

use League\Plates\Template;
use Uweyv\Framework\Configuration\ConfigRepo;

class DefaultComposer extends AbstractComposer
{
	protected ConfigRepo $configs;

	/**
	 * Construct a DefaultComposer.
	 *
	 * @param \Uweyv\Framework\Configuration\ConfigRepo $configs
	 */
	public function __construct(ConfigRepo $configs)
	{
		$this->configs = $configs;
	}

	/**
	 * Compose the Template.
	 *
	 * @param \League\Plates\Template $template
	 *
	 * @return \League\Plates\Template
	 */
	public function compose(Template $template): Template
	{
		$app = $this->configs->get('app');

		return $template->withAddedData([
			'title' => $app['name'],
		]);
	}
}
