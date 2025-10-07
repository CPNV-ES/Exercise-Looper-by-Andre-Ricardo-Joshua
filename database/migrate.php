<?php

// This script sets up the database schema.

require_once dirname(__DIR__) . '/vendor/autoload.php';

// Define BASE_DIR if it's not already defined (for command-line execution)
if (!defined('BASE_DIR')) {
    define('BASE_DIR', dirname(__DIR__));
}

// Load environment variables
$dotenv = Dotenv\Dotenv::createImmutable(BASE_DIR);
$dotenv->load();

use App\Controllers\DatabaseController;

echo "Running migrations..." . PHP_EOL;

try {
    $pdo = DatabaseController::getInstance();

    // Drop tables if they exist to start fresh
    $pdo->exec('DROP TABLE IF EXISTS fields;');
    $pdo->exec('DROP TABLE IF EXISTS exercices;');
    echo "Dropped existing tables." . PHP_EOL;

    // Create the 'exercices' table
    $pdo->exec('
        CREATE TABLE exercices (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            title VARCHAR(255) NOT NULL,
            status VARCHAR(50) NOT NULL DEFAULT "building"
        );
    ');
    echo "Created 'exercices' table." . PHP_EOL;

    // Create the 'fields' table
    $pdo->exec('
        CREATE TABLE fields (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            label VARCHAR(255) NOT NULL,
            value_kind VARCHAR(100) NOT NULL,
            exercise_id INTEGER NOT NULL,
            FOREIGN KEY (exercise_id) REFERENCES exercices(id) ON DELETE CASCADE
        );
    ');
    echo "Created 'fields' table." . PHP_EOL;

    echo "Migration completed successfully!" . PHP_EOL;

} catch (PDOException $e) {
    die("Database migration failed: " . $e->getMessage() . PHP_EOL);
}