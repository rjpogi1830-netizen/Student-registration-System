<?php
session_start();
// Redirect if already authenticated
if (isset($_SESSION["user_id"])) {
    header("Location: dashboard.php");
    exit;
}

require_once "config/database.php";

$message = "";
$messageType = "";
$emailVal = "";

// Show success message if redirected from registration
if (isset($_GET["registered"])) {
    $message = "Account created successfully! Please sign in with your credentials.";
    $messageType = "success";
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email    = trim($_POST["email"] ?? "");
    $password = $_POST["password"] ?? "";
    $emailVal = $email;

    if ($email === "" || $password === "") {
        $message = "Please enter both your email address and password.";
        $messageType = "error";
    } else {
        // Query user record with prepared statement
        $stmt = $conn->prepare("SELECT id, fullname, email, password FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            $user = $result->fetch_assoc();

            // Verify password hash
            if (password_verify($password, $user["password"])) {
                // Initialize session credentials
                $_SESSION["user_id"]  = $user["id"];
                $_SESSION["fullname"] = $user["fullname"];
                $_SESSION["email"]    = $user["email"];

                $stmt->close();
                header("Location: dashboard.php");
                exit;
            }
        }

        $message = "Invalid email or password. Please check your credentials and try again.";
        $messageType = "error";
        $stmt->close();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Sign In — Student Registration System</title>
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
            <span class="badge badge-dark" style="background: rgba(255,255,255,0.15); margin-bottom: 16px;">Student Portal</span>
            <h1>Welcome Back</h1>
            <p>Sign in to access your student dashboard, view your account overview, and manage your profile details.</p>

            <div class="auth-feature-list">
                <div class="auth-feature-item">
                    <svg class="icon icon-sm" viewBox="0 0 24 24">
                        <polyline points="20 6 9 17 4 12"></polyline>
                    </svg>
                    <span>Secure Protected Session Access</span>
                </div>
                <div class="auth-feature-item">
                    <svg class="icon icon-sm" viewBox="0 0 24 24">
                        <polyline points="20 6 9 17 4 12"></polyline>
                    </svg>
                    <span>Instant Account Details Overview</span>
                </div>
                <div class="auth-feature-item">
                    <svg class="icon icon-sm" viewBox="0 0 24 24">
                        <polyline points="20 6 9 17 4 12"></polyline>
                    </svg>
                    <span>Profile Information Updates</span>
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
                <span class="badge badge-blue" style="margin-bottom: 10px;">Portal Login</span>
                <h2>Welcome back.</h2>
                <p class="subtitle">Sign in to access your student dashboard.</p>
            </div>

            <?php if ($message): ?>
                <div class="alert alert-<?= $messageType ?>" role="alert">
                    <div class="alert-content"><?= htmlspecialchars($message) ?></div>
                    <button type="button" class="alert-close" aria-label="Close Alert">&times;</button>
                </div>
            <?php endif; ?>

            <form method="POST" id="loginForm" novalidate>
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
                               value="<?= htmlspecialchars($emailVal) ?>" required autofocus>
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
                               placeholder="Enter your password" required>
                        <button type="button" class="password-toggle-btn" data-target="password" aria-label="Toggle Password Visibility">
                            <svg class="icon icon-sm" viewBox="0 0 24 24">
                                <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                                <circle cx="12" cy="12" r="3"></circle>
                            </svg>
                        </button>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary btn-block" style="height: 50px; margin-top: 10px;">
                    Sign In
                </button>
            </form>

            <div class="auth-footer-text">
                Don't have an account? <a href="register.php" style="font-weight: 700;">Create an account</a>
            </div>
        </div>
    </div>
</div>

<script src="js/script.js"></script>
</body>
</html>
