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
    public function getAnsweringExercices(): array
    {
        $exercises = Exercise::getExercisesByStatus("answering");

        return [
            'view' => 'views/exercises/answering-list',
            'data' => [
                'title' => 'Exercises',
                'exercises' => $exercises
            ]
        ];
    }

    public function new(): array
    {
        return [
            'view' => 'views/exercises/new',
            'data' => [
                'title' => 'New Exercise',
            ]
        ];
    }

    public function create(): array
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
        }

        $exerciseId = Exercise::createExercise($title);

        return ['redirect' => '/exercises/'.$exerciseId.'/fields'];
    }

    public function changeStatus(string $id): array
    {
        if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
            return ['status_code' => 403, 'data' => ['title' => 'Forbidden']];
        }

        $status = $_POST['exercise']['status'] ?? null;
        Exercise::updateExercise(['status' => $status], $id);

        return ['redirect' => '/'];
    }
}