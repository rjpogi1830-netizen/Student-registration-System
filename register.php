<?php
session_start();
// Redirect if already logged in
if (isset($_SESSION["user_id"])) {
    header("Location: dashboard.php");
    exit;
}

require_once "config/database.php";

$message = "";
$messageType = "";
$fullnameVal = "";
$emailVal = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $fullname = trim($_POST["fullname"] ?? "");
    $email    = trim($_POST["email"] ?? "");
    $password = $_POST["password"] ?? "";
    $confirm  = $_POST["confirm_password"] ?? "";

    $fullnameVal = $fullname;
    $emailVal    = $email;

    // Server-Side Validation
    if ($fullname === "" || $email === "" || $password === "" || $confirm === "") {
        $message = "Please fill in all required fields.";
        $messageType = "error";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $message = "Please provide a valid email address.";
        $messageType = "error";
    } elseif (strlen($password) < 6) {
        $message = "Password must be at least 6 characters in length.";
        $messageType = "error";
    } elseif ($password !== $confirm) {
        $message = "Passwords do not match. Please verify and try again.";
        $messageType = "error";
    } else {
        // Check for duplicate email with prepared statement
        $checkStmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
        $checkStmt->bind_param("s", $email);
        $checkStmt->execute();
        $checkStmt->store_result();

        if ($checkStmt->num_rows > 0) {
            $message = "This email address is already registered. Please sign in or use another email.";
            $messageType = "error";
        } else {
            // Secure Password Hashing (Bcrypt)
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            // Prepared Insert Statement
            $insertStmt = $conn->prepare("INSERT INTO users (fullname, email, password) VALUES (?, ?, ?)");
            $insertStmt->bind_param("sss", $fullname, $email, $hashedPassword);

            if ($insertStmt->execute()) {
                $insertStmt->close();
                $checkStmt->close();
                header("Location: login.php?registered=1");
                exit;
            } else {
                $message = "Registration encountered a database error. Please try again.";
                $messageType = "error";
            }
            $insertStmt->close();
        }
        $checkStmt->close();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Create Account — Student Registration System</title>
<link rel="stylesheet" href="css/style.css">
</head>
<body>

<div class="auth-page">
    <!-- Left Branding Side -->
    <div class="auth-sidebar">
        <!-- Geometric Accents -->
        <div class="auth-geo-1" aria-hidden="true"></div>
        <div class="auth-geo-2" aria-hidden="true"></div>

        <a href="index.php" class="auth-sidebar-brand">
            <svg class="icon icon-md" viewBox="0 0 24 24" style="color: var(--primary);">
                <path d="M22 10v6M2 10l10-5 10 5-10 5z"></path>
                <path d="M6 12v5c3 3 9 3 12 0v-5"></path>
            </svg>
            <span>Student System</span>
        </a>

        <div class="auth-sidebar-body">
            <span class="badge badge-dark" style="background: rgba(255,255,255,0.15); margin-bottom: 16px;">Student Registration</span>
            <h1>Join the Student Portal</h1>
            <p>Create your student account to securely access your personal student dashboard and manage your records.</p>

            <div class="auth-feature-list">
                <div class="auth-feature-item">
                    <svg class="icon icon-sm" viewBox="0 0 24 24">
                        <polyline points="20 6 9 17 4 12"></polyline>
                    </svg>
                    <span>Instant Account Creation & Verification</span>
                </div>
                <div class="auth-feature-item">
                    <svg class="icon icon-sm" viewBox="0 0 24 24">
                        <polyline points="20 6 9 17 4 12"></polyline>
                    </svg>
                    <span>Bcrypt Encrypted Password Security</span>
                </div>
                <div class="auth-feature-item">
                    <svg class="icon icon-sm" viewBox="0 0 24 24">
                        <polyline points="20 6 9 17 4 12"></polyline>
                    </svg>
                    <span>Integrated Profile & Session Management</span>
                </div>
            </div>
        </div>

        <div class="auth-sidebar-footer">
            &copy; <?= date("Y") ?> Student Registration System
        </div>
    </div>

    <!-- Right Form Side -->
    <div class="auth-form-side">
        <div class="auth-card">
            <div class="auth-header">
                <span class="badge badge-blue" style="margin-bottom: 10px;">Get Started</span>
                <h2>Create your student account</h2>
                <p class="subtitle">Enter your information below to get started.</p>
            </div>

            <?php if ($message): ?>
                <div class="alert alert-<?= $messageType ?>" role="alert">
                    <div class="alert-content"><?= htmlspecialchars($message) ?></div>
                    <button type="button" class="alert-close" aria-label="Close Alert">&times;</button>
                </div>
            <?php endif; ?>

            <form method="POST" id="registerForm" novalidate>
                <!-- Full Name -->
                <div class="form-group">
                    <label for="fullname" class="form-label">Full Name</label>
                    <div class="input-wrap">
                        <svg class="icon input-icon" viewBox="0 0 24 24">
                            <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                            <circle cx="12" cy="7" r="4"></circle>
                        </svg>
                        <input type="text" name="fullname" id="fullname" class="form-input" 
                               placeholder="e.g. Juan Dela Cruz" 
                               value="<?= htmlspecialchars($fullnameVal) ?>" required autofocus>
                    </div>
                </div>

                <!-- Email Address -->
                <div class="form-group">
                    <label for="email" class="form-label">Email Address</label>
                    <div class="input-wrap">
                        <svg class="icon input-icon" viewBox="0 0 24 24">
                            <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path>
                            <polyline points="22,6 12,13 2,6"></polyline>
                        </svg>
                        <input type="email" name="email" id="email" class="form-input" 
                               placeholder="e.g. juan@student.edu" 
                               value="<?= htmlspecialchars($emailVal) ?>" required>
                    </div>
                </div>

                <!-- Password -->
                <div class="form-group">
                    <label for="password" class="form-label">Password</label>
                    <div class="input-wrap">
                        <svg class="icon input-icon" viewBox="0 0 24 24">
                            <rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect>
                            <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
                        </svg>
                        <input type="password" name="password" id="password" class="form-input" 
                               placeholder="Minimum 6 characters" minlength="6" required>
                        <button type="button" class="password-toggle-btn" data-target="password" aria-label="Toggle Password Visibility">
                            <svg class="icon icon-sm" viewBox="0 0 24 24">
                                <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                                <circle cx="12" cy="12" r="3"></circle>
                            </svg>
                        </button>
                    </div>
                    <!-- Password Strength Meter -->
                    <div class="strength-meter" id="strengthMeter">
                        <div class="strength-track">
                            <div class="strength-bar"></div>
                            <div class="strength-bar"></div>
                            <div class="strength-bar"></div>
                        </div>
                        <div class="strength-text" id="strengthLabel">Enter a password (min. 6 chars)</div>
                    </div>
                </div>

                <!-- Confirm Password -->
                <div class="form-group">
                    <label for="confirm_password" class="form-label">Confirm Password</label>
                    <div class="input-wrap">
                        <svg class="icon input-icon" viewBox="0 0 24 24">
                            <rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect>
                            <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
                        </svg>
                        <input type="password" name="confirm_password" id="confirm_password" class="form-input" 
                               placeholder="Re-enter your password" required>
                        <button type="button" class="password-toggle-btn" data-target="confirm_password" aria-label="Toggle Confirm Password Visibility">
                            <svg class="icon icon-sm" viewBox="0 0 24 24">
                                <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                                <circle cx="12" cy="12" r="3"></circle>
                            </svg>
                        </button>
                    </div>
                    <span class="form-error-msg" id="matchError" style="display:none;"></span>
                </div>

                <button type="submit" class="btn btn-primary btn-block" style="height: 50px; margin-top: 10px;">
                    Create Account
                </button>
            </form>

            <div class="auth-footer-text">
                Already have an account? <a href="login.php" style="font-weight: 700;">Sign in here</a>
            </div>
        </div>
    </div>
</div>

<script src="js/script.js"></script>
</body>
</html>
