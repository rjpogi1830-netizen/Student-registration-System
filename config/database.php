<?php
// Read cloud environment variables (for Render / Aiven) or fall back to local XAMPP defaults
$host     = getenv("DB_HOST") ?: "localhost";
$port     = (int)(getenv("DB_PORT") ?: 3306);
$dbname   = getenv("DB_NAME") ?: "student_system";
$username = getenv("DB_USER") ?: "root";
$password = getenv("DB_PASS") ?: "";

// Establish database connection
$conn = new mysqli($host, $username, $password, $dbname, $port);

if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}

$conn->set_charset("utf8mb4");
?>
