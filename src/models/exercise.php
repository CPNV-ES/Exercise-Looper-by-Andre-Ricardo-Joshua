<?php

namespace App\Models;

use App\Controllers\Database;
use PDO;

class Exercise
{
    public $id;
    public $title;
    public $status;

    protected function __construct($id, $title, $status)
    {
        $this->id = $id;
        $this->title = $title;
        $this->status = $status;
    }

    public static function getAllExercises()
    {
        $db = Database::getInstance();

        $results = Exercise::executeQuery($db, "SELECT id, title, status FROM exercises");

        $return = [];

        foreach ($results as $result) {
            $return[] = new Exercise($result['id'], $result['title'], $result['status']);
        }
        return $return;
    }

    public static function createExercise($title = '', $status = 'Building')
    {
        $db = Database::getInstance();

        Exercise::executeQuery($db, "INSERT INTO exercises (title, status) VALUES ('{$title}', '{$status}')");
    }

    public static function getExercisesByStatus($status)
    {
        $db = Database::getInstance();

        $results = Exercise::executeQuery($db, "SELECT id, title, status FROM exercises WHERE status = '{$status}'");

        $return = [];

        foreach ($results as $result) {
            $return[] = new Exercise($result['id'], $result['title'], $result['status']);
        }

        return $return;
    }

    public static function getExerciseById($id)
    {
        $db = Database::getInstance();

        $results = Exercise::executeQuery($db,"SELECT id, title, status FROM exercises WHERE id = {$id}");

        $return = [];

        foreach ($results as $result) {
            $return[] = new Exercise($result['id'], $result['title'], $result['status']);
        }

        return $return;
    }

    public static function updateExercise($fields, $id)
    {
        $db = Database::getInstance();

        $querybuilder = '';

        foreach ($fields as $field)
        {
            $querybuilder = "{fields[]} = {$field}";
        }

        Exercise::executeQuery($db,"UPDATE exercises SET {$querybuilder} WHERE id = {$id}");
    }

    //-------------------------------------------------------------------------------------------------------//

    public static function executeQuery($db, $query)
    {
        return $db->query($query)->fetchAll(PDO::FETCH_ASSOC);
    }
}
