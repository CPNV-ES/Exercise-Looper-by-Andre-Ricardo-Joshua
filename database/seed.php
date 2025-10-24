<?php

// This script seeds the database with mock data.

require_once dirname(__DIR__) . '/vendor/autoload.php';

// Define BASE_DIR if it's not already defined (for command-line execution)
if (!defined('BASE_DIR')) {
    define('BASE_DIR', dirname(__DIR__));
}

// Load environment variables from .env file
$dotenv = Dotenv\Dotenv::createImmutable(BASE_DIR);
$dotenv->load();

use App\Controllers\DatabaseController;

echo "Seeding database..." . PHP_EOL;

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

    // Temporarily disable foreign key checks for MySQL/MariaDB to allow truncation.
    if ($driver === 'mysql') {
        $pdo->exec('SET FOREIGN_KEY_CHECKS=0;');
        $pdo->exec('TRUNCATE TABLE fields;');
        $pdo->exec('TRUNCATE TABLE exercises;');
    } else {
        // For SQLite, DELETE is sufficient.
        $pdo->exec('DELETE FROM fields;');
        $pdo->exec('DELETE FROM exercises;');
    }
    // Clear existing data
    echo "Cleared existing data from tables." . PHP_EOL;

    // Insert mock exercises
    $exercises = [
        ['title' => 'Basic User Information', 'status' => 'answering'],
        ['title' => 'Customer Feedback Survey', 'status' => 'answering'],
        ['title' => 'New Project Kick-off', 'status' => 'building'],
    ];

    $stmt = $pdo->prepare('INSERT INTO exercises (title, status) VALUES (?, ?)');
    foreach ($exercises as $exercise) {
        $stmt->execute([$exercise['title'], $exercise['status']]);
    }
    echo "Inserted " . count($exercises) . " exercises." . PHP_EOL;

    // Insert mock fields for the first exercise
    $fields = [
        ['label' => 'First Name', 'value_kind' => 'single_line', 'exercise_id' => 1],
        ['label' => 'Last Name', 'value_kind' => 'single_line', 'exercise_id' => 1],
        ['label' => 'Comments', 'value_kind' => 'multi_line', 'exercise_id' => 1],
    ];
    $stmt = $pdo->prepare('INSERT INTO fields (label, value_kind, exercise_id) VALUES (?, ?, ?)');
    foreach ($fields as $field) {
        $stmt->execute([$field['label'], $field['value_kind'], $field['exercise_id']]);
    }
    echo "Inserted " . count($fields) . " fields." . PHP_EOL;

    // Re-enable foreign key checks for MySQL/MariaDB
    if ($driver === 'mysql') {
        $pdo->exec('SET FOREIGN_KEY_CHECKS=1;');
    }

    echo "Seeding completed successfully!" . PHP_EOL;

} catch (PDOException $e) {
    die("Database seeding failed: " . $e->getMessage() . PHP_EOL);
}