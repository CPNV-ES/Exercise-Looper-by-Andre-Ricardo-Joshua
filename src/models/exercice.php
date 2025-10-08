<?php

namespace App\Models;

use App\Controllers\Database;

class Exercice
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

    public static function getAllExercices()
    {
        $db = new Database();

        $results = $db->executeQuery("SELECT id, title, status FROM exercices");

        $return = [];

        foreach ($results as $result) {
            $return[] = new Exercice($result['id'], $result['title'], $result['status']);
        }
        return $return;
    }

    public static function createExercice($title)
    {
        $db = new Database();

        $db->executeQuery("INSERT INTO exercices (title) VALUES ('{$title}')");
    }
}
