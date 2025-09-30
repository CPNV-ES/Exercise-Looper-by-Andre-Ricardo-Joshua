<?php

/**
 * @file     dbConnector.php
 * @brief    Used to connect to the database
 * @author   Created by Andre.DE-CARVALHO
 * @version  17.09.2025
 */

use PDO;
use PDOException;
 

function openDbConnection() 
{
    $dbConn = null;
    // Database connection parameters
    $userName = "";
    $userPdw = "";
    $serverName = "";
    $dbName = "";

    try {
        $dbConn = new PDO("mysql:host=$serverName;dbname=$dbName", $userName, $userPdw);
    } catch (PDOException $e) {
        echo "Connection failed : " . $e->getMessage();
    }
    return $dbConn;
}

function executeQuery($query)
{
    $queryResult = null;

    $dbConn = openDBconnection();
    if($dbConn != null) {
        $statement = $dbConn->prepare($query);    
        $statement->execute();                          
        $queryResult = $statement->fetchAll(PDO::FETCH_ASSOC);
    }
    $dbConn = null;
    return $queryResult;
}

var_dump(executeQuery("SELECT * FROM exercices"));