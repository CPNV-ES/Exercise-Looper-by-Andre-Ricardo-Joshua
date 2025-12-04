<?php

namespace App\controllers;

use App\Models\Field;
use App\Models\Fulfillment;

class ResultController
{
    public function showResults($id): array
    {
        $fulfillments = Fulfillment::getFulfillmentsForExercise($id);
        $fields = Field::getByExerciseId($id);
        $answers = Fulfillment::getAllAnswersForFulfillment($fulfillments);

        if (!$fulfillments) {
            return ['status_code' => 404, 'data' => ['title' => 'Not Found']];
        }

        return [
            'view' => "views/exercises/show-results",
            'data' => [
                'fulfillments' => $fulfillments,
                'answers' => $answers,
                'fields' => $fields
            ]
        ];
    }
}