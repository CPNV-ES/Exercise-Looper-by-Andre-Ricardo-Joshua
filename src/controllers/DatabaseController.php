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
            $driver = $_ENV['DB_CONNECTION'] ?? 'sqlite';
            $host = $_ENV['DB_HOST'] ?? 'localhost';
            $port = $_ENV['DB_PORT'] ?? '3306';
            $db_name = $_ENV['DB_DATABASE'] ?? 'app';
            $user = $_ENV['DB_USERNAME'] ?? 'root';
            $pass = $_ENV['DB_PASSWORD'] ?? '';
            $charset = $_ENV['DB_CHARSET'] ?? 'utf8mb4';

            if ($driver === 'sqlite') {
                // For SQLite, DB_DATABASE should be an absolute path.
                // We ensure it's resolved relative to the project root if it's not absolute.
                $dbPath = $db_name;
                // A simple check for absolute paths on Windows (C:\) or Linux (/).
                if ($dbPath[0] !== '/' && !preg_match('/^[a-zA-Z]:\\\\/', $dbPath)) {
                    $dbPath = BASE_DIR . '/' . $dbPath;
                }
                $dsn = 'sqlite:' . $dbPath;
                $user = null;
                $pass = null;
            } else {
                $dsn = "{$driver}:host={$host};port={$port};dbname={$db_name};charset={$charset}";
            }

            $options = [
                PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION, // Throw exceptions on error
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES   => false,
            ];

            try {
                self::$instance = new PDO($dsn, $user, $pass, $options);
            } catch (PDOException $e) {
                // Log the detailed, specific error for developers to see in the server logs.
                error_log("Database connection failed: " . $e->getMessage());

                // Throw a new, more generic exception to avoid leaking sensitive
                // connection details to the user. This will be caught by the global
                // error handler and result in a 500 error page.
                throw new PDOException("Database connection failed. Check your configuration.", (int)$e->getCode(), $e);
            }
        }
 
        return self::$instance;
    }
}