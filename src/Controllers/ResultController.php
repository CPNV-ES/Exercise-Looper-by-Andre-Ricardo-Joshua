<?php

namespace App\Controllers;

use App\Models\Fulfillment;

class ResultController
{
    public function showResults($id): array
    {
        $fulfillments = Fulfillment::getFulfillmentsForExercise($id);

        if (!$fulfillments) {
            return ['status_code' => 404, 'data' => ['title' => 'Not Found']];
        }

        return [
            'view' => "views/exercises/show-results",
            'data' => [
                'fulfillments' => $fulfillments
            ]
        ];
    }
}