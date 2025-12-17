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
        $fulfillments = Fulfillment::getFulfillmentsForExercise($id);
        $field = Field::getLabelExerciseID($id, $result_id);
        $exercise = Exercise::getById($id);
        $answers = Fulfillment::getAnswersForField($field->id);

        if (!$fulfillments) {
            return ['status_code' => 404, 'data' => ['title' => 'Not Found']];
        }

        return [
            'view' => "views/exercises/show-result-detail",
            'data' => [
                'fulfillments' => $fulfillments,
                'answers' => $answers,
                'field' => $field,
                'title' => 'Exercise: <b>' . $exercise->title . '</b>',
                'exercise' => $exercise
            ]
        ];
    }

}