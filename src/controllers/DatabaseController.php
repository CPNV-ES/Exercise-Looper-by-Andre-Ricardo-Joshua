<?php
 
namespace App\Controllers;

use PDO;
use PDOException;
 
class DatabaseController
{
    private static ?PDO $instance = null;
 
    /**
     * Gets the single instance of the PDO connection.
     *
     * @return PDO The PDO instance.
     * @throws PDOException If the connection fails.
     */
    public static function getInstance(): PDO
    {
        if (self::$instance === null) {
            $dsn = 'sqlite:'.BASE_DIR.'/database/app.sqlite';

            // Ensure the directory for the SQLite database exists before connecting.
            self::ensureDirectoryExists($dsn);

            $options = [
                PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION, // Throw exceptions on error
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES   => false,
            ];
 
            self::$instance = new PDO($dsn, null, null, $options);
        }
 
        return self::$instance;
    }
    
    /**
     * Ensures the directory for the SQLite database file exists.
     *
     * @param string $dsn The DSN string.
     */
    private static function ensureDirectoryExists(string $dsn): void
    {
        if (str_starts_with($dsn, 'sqlite:')) {
            $dbPath = substr($dsn, 7); // Get the path part of the DSN
            $dbDir = dirname($dbPath);
            if (!is_dir($dbDir)) {
                mkdir($dbDir, 0777, true); // Create the directory recursively
            }
        }
    }
}