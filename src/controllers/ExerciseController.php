<?php

namespace App\Controllers;

use App\Models\Answer;
use App\Models\Fulfillment;
use App\Models\Exercise;

class ExerciseController
{
    /**
     * Handles the logic for the exercises list page.
     */
    public function getAnsweringExercises(): array
    {
        $exercises = Exercise::getByStatus("answering");

        return [
            'view' => 'views/exercises/answering-list',
            'data' => [
                'title' => 'Exercises',
                'exercises' => $exercises
            ]
        ];
    }

    public function getFilteredExercises(): array
    {
        $exercisesBuilding = Exercise::getByStatus("building");
        $exercisesAnswering = Exercise::getByStatus("answering");
        $exercisesClosing = Exercise::getByStatus("closing");

        return [
            'view' => 'views/exercises/manage',
            'data' => [
                'title' => 'Exercises',
                'exercisesBuilding' => $exercisesBuilding,
                'exercisesAnswering' => $exercisesAnswering,
                'exercisesClosing' => $exercisesClosing
            ]
        ];
    }

    public function newExercise(): array
    {
        return [
            'view' => 'views/exercises/new',
            'data' => [
                'title' => 'New Exercise',
            ]
        ];
    }

    public function createExercise(): array
    {
        if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
            return ['status_code' => 403, 'data' => ['title' => 'Forbidden']];
        }

        $title = trim($_POST['exercise']['title'] ?? '');

        // Server-side validation: ensure the title is not empty.
        if (empty($title)) {
            // Store an error message in the session to be displayed on the next page.
            $_SESSION['flash']['error'] = 'Title cannot be empty.';
            return ['redirect' => '/exercises/new'];

        } else if (strlen($title) < 4) {
            $_SESSION['flash']['error'] = 'Title must have at least 4 characters.';
            return ['redirect' => '/exercises/new'];
        }
        $exerciseId = Exercise::create($title);

        return ['redirect' => '/exercises/'.$exerciseId.'/fields'];
    }

    public function deleteExercise($id) : array
    {
        if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
            return ['status_code' => 403, 'data' => ['title' => 'Forbidden']];
        }

        Exercise::delete($id);
        return ['redirect' => "/exercises"];
    }

    public function changeExerciseStatus($id): array
    {
        if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
            return ['status_code' => 403, 'data' => ['title' => 'Forbidden']];
        }

        $status = $_POST['exercise']['status'] ?? null;
        Exercise::update(['status' => $status], $id);

        return ['redirect' => '/exercises'];
    }
}