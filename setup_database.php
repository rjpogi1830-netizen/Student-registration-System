<?php
/**
 * Database Auto-Migration & Verification Script
 * This file automatically initializes and verifies the `users` table
 * in the MySQL database (works on both local XAMPP and Cloud Aiven / Render).
 */

require_once __DIR__ . "/config/database.php";

$message = "";
$status = "success";

// SQL Schema for users table
$tableSql = "CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    fullname VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";

if ($conn->query($tableSql) === TRUE) {
    $message = "Table 'users' is verified and ready in database: " . htmlspecialchars($dbname);
} else {
    $message = "Table creation failed: " . $conn->error;
    $status = "error";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Database Setup — Student Registration System</title>
<link rel="stylesheet" href="css/style.css">
</head>
<body class="page-muted">
<div class="container">
    <div class="card center">
        <span class="badge badge-<?= $status === 'success' ? 'green' : 'amber' ?>" style="margin-bottom: 16px;">
            <?= $status === 'success' ? 'Database Connected' : 'Setup Error' ?>
        </span>
        <h2>Database Setup & Migration</h2>
        <p class="subtitle">Verifying cloud MySQL connection on Aiven / Render.</p>

        <div class="alert alert-<?= $status === 'success' ? 'success' : 'error' ?>" style="margin-top: 20px; text-align: left;">
            <div class="alert-content">
                <strong>Status:</strong> <?= htmlspecialchars($message) ?>
            </div>
        </div>

        <div class="detail-list" style="margin: 20px 0; text-align: left; background: var(--muted); padding: 16px; border-radius: var(--radius);">
            <div class="detail-row">
                <span class="detail-label">Database Host:</span>
                <span class="detail-val"><?= htmlspecialchars($host) ?></span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Database Name:</span>
                <span class="detail-val"><?= htmlspecialchars($dbname) ?></span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Port:</span>
                <span class="detail-val"><?= htmlspecialchars($port) ?></span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Charset:</span>
                <span class="detail-val">utf8mb4</span>
            </div>
        </div>

        <div style="display: flex; gap: 10px; justify-content: center; margin-top: 24px;">
            <a href="index.php" class="btn btn-primary">Go to Home Page</a>
            <a href="register.php" class="btn btn-secondary">Create Test Account</a>
        </div>
    </div>
</div>
</body>
</html>
