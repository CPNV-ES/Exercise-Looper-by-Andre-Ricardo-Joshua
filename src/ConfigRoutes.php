<?php

use App\Controllers\ExerciseController;
use App\Controllers\HomeController;
use App\Controllers\FieldController;
use App\Controllers\FulfillmentController;
use App\Controllers\ResultController;
use App\Router;

return function (Router $router) {
    $router->add('/', 'GET', [HomeController::class, 'index']);

    $router->add('/exercises/answering', 'GET', [ExerciseController::class, 'getAnsweringExercises']);

    $router->add('/exercises/new', 'GET', [ExerciseController::class, 'newExercise']);
    $router->add('/exercises', 'POST', [ExerciseController::class, 'createExercise']);
    $router->add('/exercises/{id}/fields', 'GET', [FieldController::class, 'manageFields']);
    $router->add('/exercises/{id}', 'PUT', [ExerciseController::class, 'changeExerciseStatus']);
    $router->add('/exercises/{id}/fields', 'POST', [FieldController::class, 'createField']);
    $router->add('/exercises/{id}/fields/{field_id}', 'DELETE', [FieldController::class, 'deleteField']);
    $router->add('/exercises/{id}/fields/{field_id}/edit', 'GET', [FieldController::class, 'editField']);
    $router->add('/exercises/{id}/fields/{field_id}', 'PUT', [FieldController::class, 'updateField']);

    $router->add('/exercises/{id}/fulfillments/new', 'GET', [FulfillmentController::class, 'newFulfillment']);
    $router->add('/exercises/{id}/fulfillments', 'POST', [FulfillmentController::class, 'createFulfillment']);
    $router->add('/exercises/{id}/fulfillments/{fulfillment_id}/edit', 'GET', [FulfillmentController::class, 'editFulfillment']);
    $router->add('/exercises/{id}/fulfillments/{fulfillment_id}', 'PUT', [FulfillmentController::class, 'updateFulfillment']);
    $router->add('/exercises/{id}/fulfillments/{fulfillment_id}', 'GET', [FulfillmentController::class, 'getAnswersFulfillment']);

    $router->add('/exercises/{id}/results', 'GET', [ResultController::class, 'showResults']);
    $router->add('/exercises/{id}/results/{result_id}', 'GET', [ResultController::class, 'showResultDetail']);

    $router->add('/exercises', 'GET', [ExerciseController::class, 'getFilteredExercises']);
    $router->add('/exercises/{id}', 'DELETE', [ExerciseController::class, 'deleteExercise']);
};