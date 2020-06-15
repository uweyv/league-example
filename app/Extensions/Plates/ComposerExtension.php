<?php

namespace App\Extensions\Plates;

use League\Plates\Util\Container;
use League\Plates\Engine as Plates;
use League\Plates\Extension;
use League\Container\ContainerAwareInterface;
use League\Container\ContainerAwareTrait;
use Uweyv\Framework\Configuration\Contracts\ConfigurableInterface;
use Uweyv\Framework\Configuration\Concerns\Configurable;

class ComposerExtension implements Extension, ContainerAwareInterface, ConfigurableInterface
{
	use ContainerAwareTrait;
	use Configurable;

	protected string $key = 'globalData.globals';

	public function register(Plates $plates)
	{
		$plates->getContainer()->add($this->key, []);

		$plates->addMethods([
			'addGlobal' => function(Plates $plates, $name, $value) {
				$plates->getContainer()->merge($this->key, [$name => $value]);
			},
		]);

		$plates->pushComposers(function (Container $container) {
			$composers = [];

			$composerClasses = $this->config('composers', []);

			foreach ($composerClasses as $composerClass) {
				$composers[$composerClass] = $this->container
					->get($composerClass)
					->setData($container->get($this->key));
			}

			return $composers;
		});
	}
}
