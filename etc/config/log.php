<?php

use Monolog\Logger;

return [
	'default' => 'default',

	'channels' => [

		'default' => [

			'driver' => 'monolog',

			'handlers' => [
				[
					'type' => 'file',
					'file' => 'var/logs/uweyv.log',
					'level' => Logger::WARNING,
				],
			],
		],

	],

];
