<?php

namespace App\Models;

use App\Controllers\Database;

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
        $db = new Database();

        $results = $db->executeQuery("SELECT id, title, status FROM exercises");

        $return = [];

        foreach ($results as $result) {
            $return[] = new Exercise($result['id'], $result['title'], $result['status']);
        }
        return $return;
    }

    public static function createExercise($title)
    {
        $db = new Database();

        $db->executeQuery("INSERT INTO exercises (title) VALUES ('{$title}')");
    }

    public static function getExercisesByStatus($status)
    {
        $db = new Database();

        $results = $db->executeQuery("SELECT id, title, status FROM exercises WHERE status = '{$status}'");

        $return = [];

        foreach ($results as $result) {
            $return[] = new Exercise($result['id'], $result['title'], $result['status']);
        }

        return $return;
    }

    public static function getExerciseById($id)
    {
        $db = new Database();

        $results = $db->executeQuery("SELECT id, title, status FROM exercises WHERE id = {$id}");

        $return = [];

        foreach ($results as $result) {
            $return[] = new Exercise($result['id'], $result['title'], $result['status']);
        }

        return $return;
    }

    public static function updateExercise($fields, $id)
    {
        $db = new Database();

        $querybuilder = '';

        foreach ($fields as $field)
        {
            $querybuilder = "{fields[]} = {$field}";
        }

        $db->executeQuery("UPDATE exercises SET {$querybuilder} WHERE id = {$id}");
    }
}
