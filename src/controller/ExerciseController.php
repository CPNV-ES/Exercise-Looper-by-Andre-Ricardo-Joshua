<?php

namespace App\Controller;

class ExerciseController
{
    /**
     * Handles the logic for the exercises list page.
     */
    public function index(): array
    {
        // sample data. need to change to fetch from the DB.
        $exercices = [
            ['id' => 45, 'title' => 'Le nouvel exo'],
            ['id' => 73, 'title' => 'Un autre exercice'],
            ['id' => 81, 'title' => 'Exercice de Géographie'],
        ];

        return [
            'view' => 'view/Exercises',
            'data' => [
                'title' => 'Exercises',
                'exercices' => $exercices
            ]
        ];
    }
}