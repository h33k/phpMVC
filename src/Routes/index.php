<?php

use App\Controllers\BookController;
use App\Router;

$router = new Router();

$router->get('/', BookController::class, 'index');

$router->dispatch();