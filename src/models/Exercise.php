<?php

namespace App\Models;

class Exercise extends BaseModel
{
    public $id;
    public $title;
    public $status;

    public static function getAllExercises()
    {
        $sql = "SELECT id, title, status FROM exercises";
        return self::queryAndMap($sql);
    }

    public static function getExercisesByStatus($status)
    {
        $sql = "SELECT id, title, status FROM exercises WHERE status = ?";
        return self::queryAndMap($sql, [$status]);
    }

    public static function getExerciseById($id)
    {
        $sql = "SELECT id, title, status FROM exercises WHERE id = ?";
        return self::queryAndMap($sql, [$id], true);
    }

    public static function createExercise($title)
    {
        $sql = "INSERT INTO exercises (title) VALUES (?)";
        self::executeQuery($sql, [$title]);
        return self::getLastInsertId();
    }

    public static function updateExercise($fields, $id)
    {
        $setClauses = [];
        $params = [];
        foreach ($fields as $key => $value) {
            $setClauses[] = "{$key} = ?";
            $params[] = $value;
        }

        if (empty($setClauses)) {
            return; // Nothing to update
        }

        $params[] = $id;
        $query = "UPDATE exercises SET " . implode(', ', $setClauses) . " WHERE id = ?";
        self::executeQuery($query, $params);
    }
}
