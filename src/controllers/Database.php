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
 
class Database
{
    private $userName;
    private $userPdw;
    private $dbIp;
    private $dbName;

    public function __construct()
    {
        // Database connection parameters
        $this->userName = $_ENV['DB_USERNAME'];
        $this->userPdw = $_ENV['DB_PASSWORD'];
        $this->dbIp = $_ENV['DB_HOST'];
        $this->dbName = $_ENV['DB_DATABASE'];
    }

    function openDbConnection()
    {
        $dbConn = null;

        try {
            $dbConn = new PDO("mysql:host=$this->dbIp;dbname=$this->dbName", $this->userName, $this->userPdw);
        } catch (PDOException $e) {
            echo "Connection failed : " . $e->getMessage();
        }
        return $dbConn;
    }

    function executeQuery($query)
    {
        $queryResult = null;

        $dbConn = $this->openDbConnection();
        if($dbConn != null) {
            $statement = $dbConn->prepare($query);
            $statement->execute();
            $queryResult = $statement->fetchAll(PDO::FETCH_ASSOC);
        }
        return $queryResult;
    }
}