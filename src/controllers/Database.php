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
use SQLite3;

class Database
{
    private $userName;
    private $userPdw;
    private $dbIp;
    private $dbName;
    private $db;

    public function __construct()
    {
        // Database connection link
        $this->db = new SQLite3('../db/LooperDB.db');
    }

    function openDbConnection()
    {
        /*$dbConn = null;

        try {
            $dbConn = new PDO("mysql:host=$this->dbIp;dbname=$this->dbName", $this->userName, $this->userPdw);
        } catch (PDOException $e) {
            echo "Connection failed : " . $e->getMessage();
        }
        return $dbConn;
        */
    }

    function executeQuery($query)
    {
        $queryResult = null;

        //$dbConn = $this->openDbConnection();
        if($this->db != null) {
            $statement = $this->db->query($query);
            $queryResult = $statement->fetchArray(SQLITE3_ASSOC);
        }
        return $queryResult;
    }
}