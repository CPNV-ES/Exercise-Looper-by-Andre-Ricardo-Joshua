<?php

use App\Controller\ExerciseController;
use App\Controller\HomeController;
use App\Router;

return function (Router $router) {
    $router->add('/', 'GET', [HomeController::class, 'index']);
    $router->add('/exercises/answering', 'GET', [ExerciseController::class, 'index']);
};