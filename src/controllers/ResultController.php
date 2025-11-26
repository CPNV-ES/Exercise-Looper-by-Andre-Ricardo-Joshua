<?php

namespace App\controllers;

use App\Models\Fulfillment;

class ResultController
{
    public function showResults($id): array
    {
        $fulfillments[] = Fulfillment::getFulfillmentsForExercise($id);

        return [
            'view' => "views/exercises/show-results",
            'data' => [
                'fulfillments' => $fulfillments
            ]
        ];
    }
}