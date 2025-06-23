<?php

$db_file = __DIR__ . '/gameconnect.sqlite';

try {
    $pdo = new PDO('sqlite:' . $db_file);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $create_table_query = "
    CREATE TABLE IF NOT EXISTS users (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        username TEXT NOT NULL UNIQUE,
        email TEXT NOT NULL UNIQUE,
        password TEXT NOT NULL,
        created_at DATETIME DEFAULT CURRENT_TIMESTAMP
    );";

    $pdo->exec($create_table_query);
    echo "Database and 'users' table created successfully at: " . htmlspecialchars($db_file);

} catch (PDOException $e) {
    die("Database connection or table creation failed: " . $e->getMessage());
}
?>