<?php
try {
    require __DIR__ . '/vendor/autoload.php';
    $app = require __DIR__ . '/bootstrap/app.php';

    $db = $app->make('db');

    if ($db->connection()->getSchemaBuilder()->hasTable('sessions')) {
        echo "Sessions table exists\n";
    } else {
        echo "Sessions table does NOT exist\n";
        // Create the table
        $db->connection()->statement("
            CREATE TABLE sessions (
                id VARCHAR(255) PRIMARY KEY,
                user_id BIGINT UNSIGNED NULL,
                ip_address VARCHAR(45) NULL,
                user_agent LONGTEXT NULL,
                payload LONGTEXT NOT NULL,
                last_activity INT NOT NULL,
                INDEX idx_user_id (user_id),
                INDEX idx_last_activity (last_activity)
            )
        ");
        echo "Sessions table created successfully\n";
    }
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
