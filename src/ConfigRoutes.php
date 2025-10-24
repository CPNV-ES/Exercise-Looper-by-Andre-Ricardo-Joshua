<?php

use App\Controllers\ExerciseController;
use App\Controllers\HomeController;
use App\Router;

return function (Router $router) {
    $router->add('/', 'GET', [HomeController::class, 'index']);

    $router->add('/exercises/answering', 'GET', [ExerciseController::class, 'index']);

    $router->add('/exercises/new', 'GET', [ExerciseController::class, 'new']);
    $router->add('/exercises', 'POST', [ExerciseController::class, 'create']);
    $router->add('/exercises/{id}/fields', 'GET', [ExerciseController::class, 'manageFields']);
    $router->add('/exercises/{id}', 'PUT', [ExerciseController::class, 'changeStatus']);
    $router->add('/exercises/{id}/fields', 'POST', [ExerciseController::class, 'createField']);
    $router->add('/exercises/{id}/fields/{field_id}', 'DELETE', [ExerciseController::class, 'deleteField']);
    $router->add('/exercises/{id}/fields/{field_id}/edit', 'GET', [ExerciseController::class, 'editField']);
    $router->add('/exercises/{id}/fields/{field_id}', 'PUT', [ExerciseController::class, 'updateField']);
};