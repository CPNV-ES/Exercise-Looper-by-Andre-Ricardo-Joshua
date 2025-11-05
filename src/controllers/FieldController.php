<?php

namespace App\Controllers;

use App\Models\Exercise;
use App\Models\Field;

class FieldController
{
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
}