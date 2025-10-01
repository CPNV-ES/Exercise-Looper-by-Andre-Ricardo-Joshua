<?php

namespace App\Models;

use App\Controllers\Database;

class Exercice
{
    public $id;
    public $title;

    protected function __construct($id, $title)
    {
        $this->id = $id;
        $this->title = $title;
    }

    public static function getAllExercices()
    {
        $db = new Database();
        $results = $db->executeQuery("SELECT id, title FROM exercices");

        $return = [];

        foreach ($results as $result) {
            $return[] = new Exercice($result['id'], $result['title']);
        }

        return $return;
    }
}
