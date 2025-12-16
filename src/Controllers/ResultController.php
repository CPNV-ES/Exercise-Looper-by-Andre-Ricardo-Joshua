<?php

namespace App\Controllers;

use App\Models\Exercise;
use App\Models\Field;
use App\Models\Fulfillment;

class ResultController
{
    public function showResults($id): array
    {
        $fulfillments = Fulfillment::getFulfillmentsForExercise($id);
        $fields = Field::getByExerciseId($id);
        $exercise = Exercise::getById($id);
        $answers = Fulfillment::getAllAnswersForFulfillment($fulfillments);

        if (!$fulfillments) {
            return ['status_code' => 404, 'data' => ['title' => 'Not Found']];
        }

        return [
            'view' => "views/exercises/show-results",
            'data' => [
                'fulfillments' => $fulfillments,
                'answers' => $answers,
                'fields' => $fields,
                'title' => 'Exercise: <b>' . $exercise->title . '</b>',
                'exercise' => $exercise
            ]
        ];
    }

    public function showResultDetail($id, $result_id): array
    {
        $fulfillment = Fulfillment::find($result_id);
        $fields = Field::getByExerciseId($id);
        $exercise = Exercise::getById($id);
        $answersForFulfillment = Fulfillment::getAnswersForFulfillment($result_id);
        $answers = [$result_id => $answersForFulfillment ?: []];

        if (!$fulfillment) {
            return ['status_code' => 404, 'data' => ['title' => 'Not Found']];
        }

        return [
            'view' => "views/exercises/show-result-detail",
            'data' => [
                'fulfillments' => [$fulfillment],
                'answers' => $answers,
                'fields' => $fields,
                'title' => 'Exercise: <b>' . $exercise->title . '</b>',
                'exercise' => $exercise
            ]
        ];
    }

}