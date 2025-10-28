<?php

namespace App\Controllers;

use App\Models\Answer;
use App\Models\Field;
use App\Models\Fulfillment;
use App\Models\Exercise;

class ExerciseController
{
    /**
     * Handles the logic for the exercises list page.
     */
    public function index(): array
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

    public function manageFields(string $id): array
    {
        $exercise = Exercise::getExerciseById($id);

        if ($exercise === null) {
            // If no exercise is found for the given ID, return a 404 error.
            return ['status_code' => 404, 'data' => ['title' => 'Not Found']];
        }

        $fields = Field::getFieldsForExercise($id);

        return [
            'view' => 'views/exercises/manage-fields',
            'data' => [
                'title' => 'Exercise: ' . htmlspecialchars($exercise->title ?? ''),
                'exerciseId' => $exercise->id,
                'fields' => $fields,
            ]
        ];
    }

    public function createField(string $id): array
    {
        if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
            return ['status_code' => 403, 'data' => ['title' => 'Forbidden']];
        }

        $label = trim($_POST['field']['label'] ?? '');
        $valueKind = $_POST['field']['value_kind'] ?? '';

        // Basic validation
        if (empty($label) || empty($valueKind)) {
            // In a real app, you'd want to show an error message
            return ['redirect' => '/exercises/' . $id . '/fields'];
        }

        Field::createField($label, $valueKind, $id);

        return ['redirect' => '/exercises/' . $id . '/fields'];
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

    /**
     * Shows the form for editing a specific field.
     *
     * @param string $id The exercise ID.
     * @param string $field_id The field ID.
     * @return array
     */
    public function editField(string $id, string $field_id): array
    {
        $field = Field::find($field_id);
        if (!$field) {
            return ['status_code' => 404, 'data' => ['title' => 'Not Found']];
        }

        return [
            'view' => 'views/exercises/edit-field',
            'data' => [
                'title' => 'Edit Field: ' . htmlspecialchars($field->label),
                'exerciseId' => $id,
                'field' => $field,
            ]
        ];
    }

    /**
     * Updates a specific field.
     *
     * @param string $id The exercise ID.
     * @param string $field_id The field ID.
     * @return array
     */
    public function updateField(string $id, string $field_id): array
    {
        if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
            return ['status_code' => 403, 'data' => ['title' => 'Forbidden']];
        }

        $label = trim($_POST['field']['label'] ?? '');
        $valueKind = $_POST['field']['value_kind'] ?? '';

        if (empty($label) || empty($valueKind)) {
            // In a real app, you'd show an error. For now, redirect.
            return ['redirect' => "/exercises/{$id}/fields/{$field_id}/edit"];
        }

        Field::update($field_id, ['label' => $label, 'value_kind' => $valueKind]);

        return ['redirect' => "/exercises/{$id}/fields"];
    }

    /**
     * Deletes a specific field.
     *
     * @param string $id The exercise ID.
     * @param string $field_id The field ID.
     * @return array
     */
    public function deleteField(string $id, string $field_id): array
    {
        if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
            return ['status_code' => 403, 'data' => ['title' => 'Forbidden']];
        }

        Field::delete($field_id);
        return ['redirect' => "/exercises/{$id}/fields"];
    }

    /**
     * Shows the form to create a new fulfillment for an exercise.
     *
     * @param int $id The exercise ID.
     * @return array
     */
    public function newFulfillment(string $id): array
    {
        $exercise = Exercise::getExerciseById($id);
        if (!$exercise) {
            return ['status_code' => 404, 'data' => ['title' => 'Not Found']];
        }

        $fields = Field::getFieldsForExercise($id);

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
            Answer::saveAnswer($fulfillmentId, (int)$fieldId, trim($value));
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
        $exercise = Exercise::getExerciseById($id);
        $fulfillment = Fulfillment::find($fulfillment_id);

        if (!$exercise || !$fulfillment || $fulfillment->exercise_id != $id) {
            return ['status_code' => 404, 'data' => ['title' => 'Not Found']];
        }

        $fields = Field::getFieldsForExercise($id);
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
            Answer::saveAnswer((int)$fulfillment_id, (int)$fieldId, trim($value));
        }

        $_SESSION['flash']['success'] = 'Your answers have been updated.';

        // Redirect back to the edit page.
        return ['redirect' => "/exercises/{$id}/fulfillments/{$fulfillment_id}/edit"];
    }
}