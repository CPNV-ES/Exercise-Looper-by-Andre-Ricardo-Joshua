<?php

namespace App\Models;

class Field extends BaseModel
{
    public $id;
    public $label;
    public $value_kind;
    public $exercise_id;

    public static function getByExerciseId(int $exerciseId): array
    {
        $sql = "SELECT id, label, value_kind, exercise_id FROM fields WHERE exercise_id = ?";
        return self::queryAndMap($sql, [$exerciseId]);
    }

    public static function find(int $fieldId): ?Field
    {
        $sql = "SELECT id, label, value_kind, exercise_id FROM fields WHERE id = ?";
        return self::queryAndMap($sql, [$fieldId], true);
    }

    public static function create(string $label, string $valueKind, int $exerciseId): int
    {
        $sql = "INSERT INTO fields (label, value_kind, exercise_id) VALUES (?, ?, ?)";
        self::executeQuery($sql, [$label, $valueKind, $exerciseId]);
        return self::getLastInsertId();
    }

    public static function update(int $fieldId, array $data): bool
    {
        $sql = "UPDATE fields SET label = ?, value_kind = ? WHERE id = ?";
        self::executeQuery($sql, [$data['label'], $data['value_kind'], $fieldId]);
        return true;
    }

    public static function delete(int $fieldId): bool
    {
        $sql = "DELETE FROM fields WHERE id = ?";
        self::executeQuery($sql, [$fieldId]);
        return true;
    }
}
