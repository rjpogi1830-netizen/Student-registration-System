<?php
session_start();
// Protect page: redirect if not authenticated
if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit;
}

require_once "config/database.php";

$userId = $_SESSION["user_id"];

// Fetch fresh user record from database (only real columns)
$stmt = $conn->prepare("SELECT id, fullname, email, created_at FROM users WHERE id = ?");
$stmt->bind_param("i", $userId);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 1) {
    $user = $result->fetch_assoc();
    // Keep session data synchronized
    $_SESSION["fullname"] = $user["fullname"];
    $_SESSION["email"]    = $user["email"];
    $createdAtFormatted   = date("M d, Y", strtotime($user["created_at"]));
} else {
    // If user no longer exists in DB, force logout
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
<title>Dashboard — Student Registration System</title>
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
                <a href="dashboard.php" class="portal-nav-link active">
                    <svg class="icon icon-sm" viewBox="0 0 24 24">
                        <rect x="3" y="3" width="7" height="7"></rect>
                        <rect x="14" y="3" width="7" height="7"></rect>
                        <rect x="14" y="14" width="7" height="7"></rect>
                        <rect x="3" y="14" width="7" height="7"></rect>
                    </svg>
                    <span>Dashboard</span>
                </a>

                <a href="profile.php" class="portal-nav-link">
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
         ══════════════════════════════════════════════ -->
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

            <div class="portal-topbar-title">Student Dashboard</div>

            <div class="portal-topbar-actions">
                <span class="badge badge-green">
                    <span class="status-dot green"></span>
                    Authenticated Session
                </span>
            </div>
        </header>

        <!-- Main Body -->
        <div class="portal-content">
            <!-- Greeting Banner -->
            <div class="greeting-card">
                <div class="greeting-geo" aria-hidden="true"></div>
                <span class="badge badge-dark" style="background: rgba(255,255,255,0.2); margin-bottom: 12px; color: #FFFFFF;">Account Overview</span>
                <h1>Good day, <?= htmlspecialchars($user["fullname"]) ?></h1>
                <p>Here's an overview of your account.</p>
            </div>

            <!-- Stat Blocks (Real Metrics Only) -->
            <div class="stat-grid">
                <!-- Stat 1 -->
                <div class="stat-box">
                    <div class="stat-box-icon green">
                        <svg class="icon icon-md" viewBox="0 0 24 24">
                            <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                            <polyline points="22 4 12 14.01 9 11.01"></polyline>
                        </svg>
                    </div>
                    <div>
                        <div class="stat-box-label">Account Status</div>
                        <div class="stat-box-value" style="color: var(--secondary);">Active</div>
                    </div>
                </div>

                <!-- Stat 2 -->
                <div class="stat-box">
                    <div class="stat-box-icon blue">
                        <svg class="icon icon-md" viewBox="0 0 24 24">
                            <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                            <circle cx="12" cy="7" r="4"></circle>
                        </svg>
                    </div>
                    <div>
                        <div class="stat-box-label">Profile</div>
                        <div class="stat-box-value" style="color: var(--primary);">Complete</div>
                    </div>
                </div>

                <!-- Stat 3 (Real created_at Date) -->
                <div class="stat-box">
                    <div class="stat-box-icon amber">
                        <svg class="icon icon-md" viewBox="0 0 24 24">
                            <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                            <line x1="16" y1="2" x2="16" y2="6"></line>
                            <line x1="8" y1="2" x2="8" y2="6"></line>
                            <line x1="3" y1="10" x2="21" y2="10"></line>
                        </svg>
                    </div>
                    <div>
                        <div class="stat-box-label">Member Since</div>
                        <div class="stat-box-value" style="font-size: 1.15rem;"><?= htmlspecialchars($createdAtFormatted) ?></div>
                    </div>
                </div>
            </div>

            <!-- Two Column Overview & Quick Actions -->
            <div class="portal-grid">
                <!-- Account Overview Card (Strictly Real Columns) -->
                <div class="portal-card">
                    <div class="portal-card-header">
                        <h2>Account Overview</h2>
                        <span class="badge badge-muted">User Record</span>
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

                <!-- Quick Actions Card -->
                <div class="portal-card">
                    <div class="portal-card-header">
                        <h2>Quick Actions</h2>
                    </div>

                    <div class="quick-actions-list">
                        <a href="profile.php" class="btn btn-secondary btn-block" style="justify-content: flex-start;">
                            <svg class="icon icon-sm" viewBox="0 0 24 24" style="color: var(--primary);">
                                <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                <circle cx="12" cy="7" r="4"></circle>
                            </svg>
                            <span>View Profile</span>
                        </a>

                        <a href="profile.php#edit-section" class="btn btn-secondary btn-block" style="justify-content: flex-start;">
                            <svg class="icon icon-sm" viewBox="0 0 24 24" style="color: var(--secondary);">
                                <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                                <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                            </svg>
                            <span>Edit Information</span>
                        </a>

                        <a href="logout.php" class="btn btn-secondary btn-block" style="justify-content: flex-start; color: var(--danger);">
                            <svg class="icon icon-sm" viewBox="0 0 24 24" style="color: var(--danger);">
                                <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path>
                                <polyline points="16 17 21 12 16 7"></polyline>
                                <line x1="21" y1="12" x2="9" y2="12"></line>
                            </svg>
                            <span>Logout</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </main>
</div>

<script src="js/script.js"></script>
</body>
</html>
