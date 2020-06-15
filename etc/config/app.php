<?php

use App\Resolution\Providers;

return [
	'name' => env('APP_NAME', 'Uweyv'),

	'providers' => [
		// base providers
		Providers\AppProvider::class,
		Providers\LogProvider::class,
		Providers\WebProvider::class,
	],
];
