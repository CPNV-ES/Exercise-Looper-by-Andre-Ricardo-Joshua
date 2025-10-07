<?php

namespace App\Controllers;

use App\Models\Exercise;

class ExerciseController
{
    /**
     * Handles the logic for the exercises list page.
     */
    public function index(): array
    {
        $exercises = Exercise::getExercisesByStatus("Answering");

        return [
            'view' => 'views/exercises/answering-list',
            'data' => [
                'title' => 'Exercises',
                'exercises' => $exercises
            ]
        ];
    }
}