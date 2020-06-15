<?php

return [
	'routes' => [
		'web' => 'etc/routes/web',
	],

	'plates' => [
		'base_dir' => 'res/templates',
		'ext' => 'phtml',
		'escape_encoding' => 'UTF-8',
	],

	'composers' => [
		App\Web\Responses\Composers\DefaultComposer::class,
	],

	'emitters' => [
		Uweyv\Framework\Web\Emission\Strategies\GenericEmitterStrategy::class,
	],
];
