<?php
// database/config.php
// DB connection using PDO

$DB_HOST = '127.0.0.1';
$DB_NAME = 'resume_db';
$DB_USER = 'root';
$DB_PASS = '';

// App base - change if you use a different folder name
$BASE_URL = 'http://localhost/dynamic_resume/';

try {
    $conn = new PDO(
        "mysql:host={$DB_HOST};dbname={$DB_NAME};charset=utf8mb4",
        $DB_USER,
        $DB_PASS,
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
    );
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}

// start session for the app (only start once per request)
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>
