<?php

namespace App\Controllers;

use App\Models\Answer;
use App\Models\Exercise;
use App\Models\Fulfillment;
use App\Models\Field;

class FulfillmentController
{

    /**
     * Shows the form to create a new fulfillment for an exercise.
     *
     * @param int $id The exercise ID.
     * @return array
     */
    public function newFulfillment(string $id): array
    {
        $exercise = Exercise::getById($id);
        if (!$exercise) {
            return ['status_code' => 404, 'data' => ['title' => 'Not Found']];
        }

        $fields = Field::getByExerciseId($id);

        return [
            'view' => 'views/exercises/fulfillment-form',
            'data' => [
                'title' => 'Your take on: ' . htmlspecialchars($exercise->title),
                'exercise' => $exercise,
                'fields' => $fields,
                'fulfillment' => null, // No fulfillment yet
                'answers' => [], // No answers yet
                'form_action' => "/exercises/{$id}/fulfillments"
            ]
        ];
    }

    /**
     * Stores a new fulfillment for an exercise.
     *
     * @param string $id The exercise ID.
     * @return array
     */
    public function createFulfillment(string $id): array
    {
        if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
            return ['status_code' => 403, 'data' => ['title' => 'Forbidden']];
        }

        // Create a new fulfillment record and get its ID.
        $fulfillmentId = Fulfillment::create((int)$id);

        // Save the answers.
        $answers = $_POST['answers'] ?? [];
        foreach ($answers as $fieldId => $value) {
            Answer::save($fulfillmentId, (int)$fieldId, trim($value));
        }

        $_SESSION['flash']['success'] = 'Your answers have been saved. You can come back to this page later to continue.';

        // Redirect to the edit page for this new fulfillment.
        return ['redirect' => "/exercises/{$id}/fulfillments/{$fulfillmentId}/edit"];
    }

    /**
     * Shows the form to edit an existing fulfillment.
     *
     * @param int $id The exercise ID.
     * @param int $fulfillment_id The fulfillment ID.
     * @return array
     */
    public function editFulfillment(string $id, string $fulfillment_id): array
    {
        $exercise = Exercise::getById($id);
        $fulfillment = Fulfillment::find($fulfillment_id);

        if (!$exercise || !$fulfillment || $fulfillment->exercise_id != $id) {
            return ['status_code' => 404, 'data' => ['title' => 'Not Found']];
        }

        $fields = Field::getByExerciseId($id);
        $answers = Fulfillment::getAnswersForFulfillment($fulfillment_id);

        return [
            'view' => 'views/exercises/fulfillment-form',
            'data' => [
                'title' => 'Editing your take on: ' . htmlspecialchars($exercise->title),
                'exercise' => $exercise,
                'fields' => $fields,
                'fulfillment' => $fulfillment,
                'answers' => $answers,
                'form_action' => "/exercises/{$id}/fulfillments/{$fulfillment_id}"
            ]
        ];
    }

    public function updateFulfillment(string $id, string $fulfillment_id): array
    {
        if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
            return ['status_code' => 403, 'data' => ['title' => 'Forbidden']];
        }

        // Ensure the fulfillment exists and belongs to the correct exercise.
        $fulfillment = Fulfillment::find($fulfillment_id);
        if (!$fulfillment || $fulfillment->exercise_id != $id) {
            return ['status_code' => 404, 'data' => ['title' => 'Not Found']];
        }

        $answers = $_POST['answers'] ?? [];
        foreach ($answers as $fieldId => $value) {
            // Use an "upsert" logic to update existing answers or insert new ones.
            Answer::save((int)$fulfillment_id, (int)$fieldId, trim($value));
        }

        $_SESSION['flash']['success'] = 'Your answers have been updated.';

        // Redirect back to the edit page.
        return ['redirect' => "/exercises/{$id}/fulfillments/{$fulfillment_id}/edit"];
    }

    public function getAnswersFulfillment($id,$fulfillment_id): array
    {
        $title = Exercise::getById($id)->title;
        $answers = Fulfillment::getAnswersForFulfillment($fulfillment_id);

        return [
            'view' => 'views/exercises/show-result-fulfillment',
            'data' => [
                'title' => $title,
                'answers' => $answers,
            ]
        ];
    }
}