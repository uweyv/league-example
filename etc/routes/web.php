<?php

use App\Web\Routing\Controllers;

$router->get('/', [Controllers\IndexController::class, 'index']);
$router->get('/about', [Controllers\AboutController::class, 'index']);
