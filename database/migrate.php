<?php

// This script sets up the database schema.

require_once dirname(__DIR__) . '/vendor/autoload.php';

// Define BASE_DIR if it's not already defined (for command-line execution)
if (!defined('BASE_DIR')) {
    define('BASE_DIR', dirname(__DIR__));
}

// Load environment variables from .env file
$dotenv = Dotenv\Dotenv::createImmutable(BASE_DIR);
$dotenv->load();

use App\Controllers\DatabaseController;

echo "Running migrations..." . PHP_EOL;

try {
    $driver = $_ENV['DB_CONNECTION'] ?? 'sqlite';

    // For SQLite, ensure the database directory exists before connecting.
    if ($driver === 'sqlite') {
        $dbPath = BASE_DIR . '/' . $_ENV['DB_DATABASE'];
        $dbDir = dirname($dbPath);
        if (!is_dir($dbDir)) {
            mkdir($dbDir, 0777, true); // Create the directory recursively
            echo "Created database directory: " . $dbDir . PHP_EOL;
        }
    }

    $pdo = DatabaseController::getInstance();

    // Temporarily disable foreign key checks for MySQL/MariaDB to avoid drop order issues.
    if ($driver === 'mysql') {
        $pdo->exec('SET FOREIGN_KEY_CHECKS=0;');
    }

    // Drop tables if they exist to start fresh
    $pdo->exec('DROP TABLE IF EXISTS fields;');
    $pdo->exec('DROP TABLE IF EXISTS exercises;');
    echo "Dropped existing tables." . PHP_EOL;

    if ($driver === 'mysql') {
        // MySQL/MariaDB specific schema
        $pdo->exec('
            CREATE TABLE exercises (
                id INT PRIMARY KEY AUTO_INCREMENT,
                title VARCHAR(255) NOT NULL,
                status VARCHAR(50) NOT NULL DEFAULT \'building\'
            );
        ');
        $pdo->exec('
            CREATE TABLE fields (
                id INT PRIMARY KEY AUTO_INCREMENT,
                label VARCHAR(255) NOT NULL,
                value_kind VARCHAR(100) NOT NULL,
                exercise_id INT NOT NULL,
                FOREIGN KEY (exercise_id) REFERENCES exercises(id) ON DELETE CASCADE
            );
        ');
    } else {
        // SQLite specific schema
        $pdo->exec('
            CREATE TABLE exercises (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                title VARCHAR(255) NOT NULL,
                status VARCHAR(50) NOT NULL DEFAULT \'building\'
            );
        ');
        $pdo->exec('
            CREATE TABLE fields (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                label VARCHAR(255) NOT NULL,
                value_kind VARCHAR(100) NOT NULL,
                exercise_id INTEGER NOT NULL,
                FOREIGN KEY (exercise_id) REFERENCES exercises(id) ON DELETE CASCADE
            );
        ');
    }

    echo "Created 'exercises' table." . PHP_EOL;
    echo "Created 'fields' table." . PHP_EOL;

    // Re-enable foreign key checks for MySQL/MariaDB
    if ($driver === 'mysql') {
        $pdo->exec('SET FOREIGN_KEY_CHECKS=1;');
    }

    echo "Migration completed successfully!" . PHP_EOL;

} catch (PDOException $e) {
    die("Database migration failed: " . $e->getMessage() . PHP_EOL);
}