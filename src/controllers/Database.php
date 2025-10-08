<?php

/**
 * @file     dbConnector.php
 * @brief    Used to connect to the database
 * @author   Created by Andre.DE-CARVALHO
 * @version  17.09.2025
 */

namespace App\Controllers;

use PDO;
use PDOException;
//use SQLite3;

class Database
{
    private $db = SOURCE_DIR."/db/LooperDB.db";
    private $pdo;

    public function __construct()
    {
        // Database connection link
        try {
            $this->pdo = new PDO("sqlite:".$this->db);
        } catch (PDOException $e) {
            echo "Connection failed : " . $e->getMessage();
        }
        return $this->pdo;
    }

    public function executeQuery($query)
    {
        $queryResult = null;

        if($this->pdo != null) {
            $statement = $this->pdo->prepare($query);
            $statement->execute();
            $queryResult = $statement->fetchAll(PDO::FETCH_ASSOC);
        }
        return $queryResult;
    }
}