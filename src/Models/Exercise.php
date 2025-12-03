<?php

namespace App\Models;

class Exercise extends BaseModel
{
    public $id;
    public $title;
    public $status;

    public static function getAll()
    {
        $sql = "SELECT id, title, status FROM exercises";
        return self::queryAndMap($sql);
    }

    public static function getByStatus($status)
    {
        $sql = "SELECT id, title, status FROM exercises WHERE status = ?";
        return self::queryAndMap($sql, [$status]);
    }

    public static function getById($id)
    {
        $sql = "SELECT id, title, status FROM exercises WHERE id = ?";
        return self::queryAndMap($sql, [$id], true);
    }

    public static function create($title)
    {
        $sql = "INSERT INTO exercises (title) VALUES (?)";
        self::executeQuery($sql, [$title]);
        return self::getLastInsertId();
    }

    public static function delete($id)
    {
        $sql = "DELETE FROM exercises WHERE id = ?";
        self::executeQuery($sql, [$id]);
    }

    public static function update($fields, $id)
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
