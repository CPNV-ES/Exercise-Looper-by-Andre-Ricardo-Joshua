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
    private static ?PDO $instance = null;

    public static function getInstance(): PDO
    {
        if(self::$instance === null)
        {
            $dsn = 'sqlite:'.BASE_DIR.'/src/database/LooperDB.db';

            $options = [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => false
            ];

            self::$instance = new PDO($dsn, null, null, $options);
        }

        return self::$instance;
    }
}