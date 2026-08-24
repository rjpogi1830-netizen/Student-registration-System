<?php
session_start();
// Protect page: redirect if not authenticated
if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit;
}

require_once "config/database.php";

$userId = $_SESSION["user_id"];
$message = "";
$messageType = "";

// Handle Profile Update Request
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["action"]) && $_POST["action"] === "update_profile") {
    $newFullname = trim($_POST["fullname"] ?? "");
    $newEmail    = trim($_POST["email"] ?? "");

    if ($newFullname === "" || $newEmail === "") {
        $message = "Please provide both your full name and email address.";
        $messageType = "error";
    } elseif (!filter_var($newEmail, FILTER_VALIDATE_EMAIL)) {
        $message = "Please enter a valid email address.";
        $messageType = "error";
    } else {
        // Verify email uniqueness excluding current user
        $checkStmt = $conn->prepare("SELECT id FROM users WHERE email = ? AND id != ?");
        $checkStmt->bind_param("si", $newEmail, $userId);
        $checkStmt->execute();
        $checkStmt->store_result();

        if ($checkStmt->num_rows > 0) {
            $message = "This email address is already in use by another account.";
            $messageType = "error";
        } else {
            // Update user record in database
            $updateStmt = $conn->prepare("UPDATE users SET fullname = ?, email = ? WHERE id = ?");
            $updateStmt->bind_param("ssi", $newFullname, $newEmail, $userId);

            if ($updateStmt->execute()) {
                // Update PHP session variables immediately
                $_SESSION["fullname"] = $newFullname;
                $_SESSION["email"]    = $newEmail;
                $message = "Your profile information has been updated successfully!";
                $messageType = "success";
            } else {
                $message = "Database update failed. Please try again.";
                $messageType = "error";
            }
            $updateStmt->close();
        }
        $checkStmt->close();
    }
}

// Fetch current user details from MySQL (only real columns)
$stmt = $conn->prepare("SELECT id, fullname, email, created_at FROM users WHERE id = ?");
$stmt->bind_param("i", $userId);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 1) {
    $user = $result->fetch_assoc();
    $createdAtFormatted = date("M d, Y", strtotime($user["created_at"]));
} else {
    header("Location: logout.php");
    exit;
}
$stmt->close();

$initial = strtoupper(substr($user["fullname"], 0, 1));
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>My Profile — Student Registration System</title>
<link rel="stylesheet" href="css/style.css">
</head>
<body>

<div class="portal-layout">
    <!-- ══════════════════════════════════════════════════════════
         PORTAL SIDEBAR
         ══════════════════════════════════════════════════════════ -->
    <aside class="portal-sidebar" id="portalSidebar">
        <div class="portal-sidebar-top">
            <a href="dashboard.php" class="portal-brand">
                <svg class="icon icon-md" viewBox="0 0 24 24" style="color: var(--primary);">
                    <path d="M22 10v6M2 10l10-5 10 5-10 5z"></path>
                    <path d="M6 12v5c3 3 9 3 12 0v-5"></path>
                </svg>
                <span>Student System</span>
            </a>

            <nav class="portal-nav" aria-label="Portal Navigation">
                <a href="dashboard.php" class="portal-nav-link">
                    <svg class="icon icon-sm" viewBox="0 0 24 24">
                        <rect x="3" y="3" width="7" height="7"></rect>
                        <rect x="14" y="3" width="7" height="7"></rect>
                        <rect x="14" y="14" width="7" height="7"></rect>
                        <rect x="3" y="14" width="7" height="7"></rect>
                    </svg>
                    <span>Dashboard</span>
                </a>

                <a href="profile.php" class="portal-nav-link active">
                    <svg class="icon icon-sm" viewBox="0 0 24 24">
                        <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                        <circle cx="12" cy="7" r="4"></circle>
                    </svg>
                    <span>My Profile</span>
                </a>

                <a href="profile.php#edit-section" class="portal-nav-link">
                    <svg class="icon icon-sm" viewBox="0 0 24 24">
                        <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                        <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                    </svg>
                    <span>Account Settings</span>
                </a>
            </nav>
        </div>

        <div class="portal-sidebar-bottom">
            <div class="portal-user-badge">
                <div class="portal-avatar"><?= htmlspecialchars($initial) ?></div>
                <div class="portal-user-info">
                    <div class="portal-user-name"><?= htmlspecialchars($user["fullname"]) ?></div>
                    <div class="portal-user-email"><?= htmlspecialchars($user["email"]) ?></div>
                </div>
            </div>
            <a href="logout.php" class="btn btn-secondary btn-sm btn-block" style="background: rgba(255,255,255,0.08); color: #FFFFFF;">
                <svg class="icon icon-sm" viewBox="0 0 24 24">
                    <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path>
                    <polyline points="16 17 21 12 16 7"></polyline>
                    <line x1="21" y1="12" x2="9" y2="12"></line>
                </svg>
                <span>Logout</span>
            </a>
        </div>
    </aside>

    <!-- ══════════════════════════════════════════════════════════
         MAIN CONTENT CANVAS
         ══════════════════════════════════════════════════════════ -->
    <main class="portal-main">
        <!-- Top Bar -->
        <header class="portal-topbar">
            <button type="button" class="portal-mobile-toggle" id="portalMobileToggle" aria-label="Toggle Portal Sidebar">
                <svg class="icon icon-md" viewBox="0 0 24 24">
                    <line x1="3" y1="12" x2="21" y2="12"></line>
                    <line x1="3" y1="6" x2="21" y2="6"></line>
                    <line x1="3" y1="18" x2="21" y2="18"></line>
                </svg>
            </button>

            <div class="portal-topbar-title">My Profile</div>

            <div class="portal-topbar-actions">
                <a href="dashboard.php" class="btn btn-secondary btn-sm">
                    <svg class="icon icon-sm" viewBox="0 0 24 24">
                        <line x1="19" y1="12" x2="5" y2="12"></line>
                        <polyline points="12 19 5 12 12 5"></polyline>
                    </svg>
                    <span>Back to Dashboard</span>
                </a>
            </div>
        </header>

        <!-- Main Body -->
        <div class="portal-content">
            <?php if ($message): ?>
                <div class="alert alert-<?= $messageType ?>" role="alert">
                    <div class="alert-content"><?= htmlspecialchars($message) ?></div>
                    <button type="button" class="alert-close" aria-label="Close Alert">&times;</button>
                </div>
            <?php endif; ?>

            <div class="portal-grid">
                <!-- Left: View Profile Card (Only Real DB Columns) -->
                <div class="portal-card">
                    <div class="portal-card-header">
                        <div>
                            <h2>Account Details</h2>
                            <p class="subtitle" style="margin: 0;">View your student account information.</p>
                        </div>
                        <span class="badge badge-green">
                            <span class="status-dot green"></span>
                            Active
                        </span>
                    </div>

                    <div class="detail-list">
                        <div class="detail-row">
                            <span class="detail-label">Full Name</span>
                            <span class="detail-val"><?= htmlspecialchars($user["fullname"]) ?></span>
                        </div>
                        <div class="detail-row">
                            <span class="detail-label">Email Address</span>
                            <span class="detail-val"><?= htmlspecialchars($user["email"]) ?></span>
                        </div>
                        <div class="detail-row">
                            <span class="detail-label">Account ID</span>
                            <span class="detail-val">#ACC-<?= str_pad($user["id"], 5, "0", STR_PAD_LEFT) ?></span>
                        </div>
                        <div class="detail-row">
                            <span class="detail-label">Registration Date</span>
                            <span class="detail-val"><?= htmlspecialchars($createdAtFormatted) ?></span>
                        </div>
                    </div>
                </div>

                <!-- Right: Edit Profile Form (Real MySQL Update) -->
                <div class="portal-card" id="edit-section">
                    <div class="portal-card-header">
                        <div>
                            <h2>Edit Information</h2>
                            <p class="subtitle" style="margin: 0;">Update your account name and email.</p>
                        </div>
                    </div>

                    <form method="POST" id="editProfileForm" novalidate>
                        <input type="hidden" name="action" value="update_profile">

                        <!-- Full Name -->
                        <div class="form-group">
                            <label for="edit_fullname" class="form-label">Full Name</label>
                            <div class="input-wrap">
                                <svg class="icon input-icon" viewBox="0 0 24 24">
                                    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                    <circle cx="12" cy="7" r="4"></circle>
                                </svg>
                                <input type="text" name="fullname" id="edit_fullname" class="form-input" 
                                       value="<?= htmlspecialchars($user["fullname"]) ?>" required>
                            </div>
                        </div>

                        <!-- Email Address -->
                        <div class="form-group">
                            <label for="edit_email" class="form-label">Email Address</label>
                            <div class="input-wrap">
                                <svg class="icon input-icon" viewBox="0 0 24 24">
                                    <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path>
                                    <polyline points="22,6 12,13 2,6"></polyline>
                                </svg>
                                <input type="email" name="email" id="edit_email" class="form-input" 
                                       value="<?= htmlspecialchars($user["email"]) ?>" required>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary btn-block" style="height: 46px; margin-top: 12px;">
                            Save Changes
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </main>
</div>

<script src="js/script.js"></script>
</body>
</html>
