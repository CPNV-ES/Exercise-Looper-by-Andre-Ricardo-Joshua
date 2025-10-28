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

    $pdo = DatabaseController::getInstance();

    // Temporarily disable foreign key checks for MySQL/MariaDB to allow truncation.
    if ($driver === 'mysql') {
        $pdo->exec('SET FOREIGN_KEY_CHECKS=0;');
        $pdo->exec('TRUNCATE TABLE answers;');
        $pdo->exec('TRUNCATE TABLE fulfillments;');
        $pdo->exec('TRUNCATE TABLE fields;');
        $pdo->exec('TRUNCATE TABLE exercises;');
    } else {
        // For SQLite, DELETE is sufficient.
        $pdo->exec('DELETE FROM answers;');
        $pdo->exec('DELETE FROM fulfillments;');
        $pdo->exec('DELETE FROM fields;');
        $pdo->exec('DELETE FROM exercises;');
        // Reset the autoincrement counter for SQLite tables.
        $pdo->exec('DELETE FROM sqlite_sequence WHERE name="exercises";');
        $pdo->exec('DELETE FROM sqlite_sequence WHERE name="fields";');
        $pdo->exec('DELETE FROM sqlite_sequence WHERE name="fulfillments";');
        $pdo->exec('DELETE FROM sqlite_sequence WHERE name="answers";');
    }
    // Clear existing data
    echo "Cleared existing data from tables." . PHP_EOL;

    // Define mock data in a structured way
    $data = [
        [
            'exercise' => ['title' => 'Basic User Information', 'status' => 'answering'],
            'fields' => [
                ['label' => 'First Name', 'value_kind' => 'single_line'],
                ['label' => 'Last Name', 'value_kind' => 'single_line_list'],
                ['label' => 'Comments', 'value_kind' => 'multi_line'],
            ],
            'fulfillments' => [
                [
                    'answers' => [
                        'First Name' => 'Jane',
                        'Last Name' => "Doe\nSmith", // Example for single_line_list
                    ]
                ]
            ]
        ],
        [
            'exercise' => ['title' => 'Customer Feedback Survey', 'status' => 'answering'],
            'fields' => [
                ['label' => 'Product Rating (1-5)', 'value_kind' => 'single_line'],
                ['label' => 'Feedback', 'value_kind' => 'multi_line'],
            ],
            'fulfillments' => [] // No fulfillments for this one yet
        ],
        [
            'exercise' => ['title' => 'New Project Kick-off', 'status' => 'building'],
            'fields' => [], // No fields for this one yet
            'fulfillments' => []
        ]
    ];

    // Prepare statements
    $exerciseStmt = $pdo->prepare('INSERT INTO exercises (title, status) VALUES (?, ?)');
    $fieldStmt = $pdo->prepare('INSERT INTO fields (label, value_kind, exercise_id) VALUES (?, ?, ?)');
    $fulfillmentStmt = $pdo->prepare('INSERT INTO fulfillments (exercise_id) VALUES (?)');
    $answerStmt = $pdo->prepare('INSERT INTO answers (fulfillment_id, field_id, value) VALUES (?, ?, ?)');

    foreach ($data as $item) {
        // 1. Insert Exercise and get its ID
        $exerciseStmt->execute([$item['exercise']['title'], $item['exercise']['status']]);
        $exerciseId = $pdo->lastInsertId();

        $fieldIds = []; // To store [label => id] mapping for answers
        // 2. Insert Fields for this Exercise
        foreach ($item['fields'] as $field) {
            $fieldStmt->execute([$field['label'], $field['value_kind'], $exerciseId]);
            $fieldIds[$field['label']] = $pdo->lastInsertId();
        }

        // 3. Insert Fulfillments and their Answers
        foreach ($item['fulfillments'] as $fulfillment) {
            $fulfillmentStmt->execute([$exerciseId]);
            $fulfillmentId = $pdo->lastInsertId();

            foreach ($fulfillment['answers'] as $label => $value) {
                if (isset($fieldIds[$label])) {
                    $answerStmt->execute([$fulfillmentId, $fieldIds[$label], $value]);
                }
            }
        }
    }
    echo "Seeding from structured data completed." . PHP_EOL;

    // Re-enable foreign key checks for MySQL/MariaDB
    if ($driver === 'mysql') {
        $pdo->exec('SET FOREIGN_KEY_CHECKS=1;');
    }

    echo "Seeding completed successfully!" . PHP_EOL;

} catch (PDOException $e) {
    die("Database seeding failed: " . $e->getMessage() . PHP_EOL);
}