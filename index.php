<?php
session_start();
// If user is already authenticated, redirect straight to dashboard
if (isset($_SESSION["user_id"])) {
    header("Location: dashboard.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Student Registration System — Modern Student Portal</title>
<link rel="stylesheet" href="css/style.css">
</head>
<body id="home">

<!-- ══════════════════════════════════════════════════════════════
     1. NAVIGATION BAR
     ══════════════════════════════════════════════════════════════ -->
<header>
    <nav class="landing-nav" id="landingNav" aria-label="Main Navigation">
        <a href="#home" class="brand">
            <svg class="icon icon-md" viewBox="0 0 24 24" style="color: var(--primary);">
                <path d="M22 10v6M2 10l10-5 10 5-10 5z"></path>
                <path d="M6 12v5c3 3 9 3 12 0v-5"></path>
            </svg>
            <span>Student System</span>
        </a>

        <button class="nav-toggle" id="navToggle" aria-label="Toggle Navigation Menu">
            <svg class="icon icon-md" viewBox="0 0 24 24">
                <line x1="3" y1="12" x2="21" y2="12"></line>
                <line x1="3" y1="6" x2="21" y2="6"></line>
                <line x1="3" y1="18" x2="21" y2="18"></line>
            </svg>
        </button>

        <div class="nav-center" id="navMenu">
            <a href="#home" class="nav-link active">Home</a>
            <a href="#features" class="nav-link">Features</a>
            <a href="#how-it-works" class="nav-link">How It Works</a>
            <a href="#benefits" class="nav-link">Benefits</a>
            <a href="#team" class="nav-link">Team</a>
        </div>

        <div class="nav-actions">
            <a href="login.php" class="btn btn-secondary btn-sm">Login</a>
            <a href="register.php" class="btn btn-primary btn-sm">Create Account</a>
        </div>
    </nav>
</header>

<!-- ══════════════════════════════════════════════════════════════
     2. HERO SECTION & SYSTEM PREVIEW
     ══════════════════════════════════════════════════════════════ -->
<section class="hero-section">
    <!-- Geometric Background Shapes -->
    <div class="hero-geo hero-geo-circle-lg" aria-hidden="true"></div>
    <div class="hero-geo hero-geo-circle-sm" aria-hidden="true"></div>
    <div class="hero-geo hero-geo-square" aria-hidden="true"></div>

    <div class="container-wide">
        <div class="hero-inner">
            <div class="hero-content">
                <span class="badge badge-dark" style="margin-bottom: 16px; background: rgba(255,255,255,0.18);">Student Portal</span>
                <h1>Your Student Account.<br>Simple. Secure. Connected.</h1>
                <p class="subtitle">Create your account, manage your information, and access your student dashboard through one simple system.</p>
                <div class="btn-group">
                    <a href="register.php" class="btn btn-white">Create Account</a>
                    <a href="login.php" class="btn btn-outline" style="border-color: rgba(255,255,255,0.5); color: #FFFFFF;">Sign In</a>
                </div>
            </div>

            <!-- Visual System Preview -->
            <div class="hero-preview">
                <div class="preview-mockup" aria-label="Student System Dashboard Interface Preview">
                    <div class="mockup-topbar">
                        <span class="mockup-brand">
                            <svg class="icon icon-sm" viewBox="0 0 24 24" style="display:inline; margin-right:4px;">
                                <path d="M22 10v6M2 10l10-5 10 5-10 5z"></path>
                                <path d="M6 12v5c3 3 9 3 12 0v-5"></path>
                            </svg>
                            Student Portal
                        </span>
                        <div class="mockup-dots" aria-hidden="true">
                            <span></span>
                            <span></span>
                            <span></span>
                        </div>
                    </div>
                    <div class="mockup-body">
                        <div class="mockup-greeting">Good day, Alex Morgan!</div>
                        <div class="mockup-stats">
                            <div class="mockup-stat">
                                <div class="mockup-stat-label">Account Status</div>
                                <div class="mockup-stat-val" style="color: var(--secondary);">Active</div>
                            </div>
                            <div class="mockup-stat">
                                <div class="mockup-stat-label">Profile Status</div>
                                <div class="mockup-stat-val" style="color: var(--primary);">Complete</div>
                            </div>
                        </div>
                        <div class="mockup-card">
                            <div class="mockup-card-title">Account Overview</div>
                            <div class="mockup-row">
                                <span style="color: var(--text-muted);">Full Name</span>
                                <span style="font-weight: 600;">Alex Morgan</span>
                            </div>
                            <div class="mockup-row">
                                <span style="color: var(--text-muted);">Email Address</span>
                                <span style="font-weight: 600;">alex.morgan@student.edu</span>
                            </div>
                            <div class="mockup-row">
                                <span style="color: var(--text-muted);">Account ID</span>
                                <span style="font-weight: 600; color: var(--primary);">#ACC-00012</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ══════════════════════════════════════════════════════════════
     3. FEATURES SECTION
     ══════════════════════════════════════════════════════════════ -->
<section class="landing-section" id="features" style="background: var(--bg);">
    <div class="container-wide">
        <div class="section-header">
            <span class="badge badge-blue" style="margin-bottom: 12px;">Core Capabilities</span>
            <h2>Everything You Need in One Place</h2>
            <p class="subtitle">Built with standard web technologies and structured specifically for seamless student account management.</p>
        </div>

        <div class="features-grid">
            <!-- 01 Easy Registration -->
            <div class="feature-card blue">
                <div class="feature-icon-wrap" style="color: var(--primary);">
                    <svg class="icon icon-md" viewBox="0 0 24 24">
                        <path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                        <circle cx="8.5" cy="7" r="4"></circle>
                        <line x1="20" y1="8" x2="20" y2="14"></line>
                        <line x1="23" y1="11" x2="17" y2="11"></line>
                    </svg>
                </div>
                <h3>01. Easy Registration</h3>
                <p>Create your student account in seconds with built-in instant password validation and strength checking.</p>
            </div>

            <!-- 02 Secure Authentication -->
            <div class="feature-card green">
                <div class="feature-icon-wrap" style="color: var(--secondary);">
                    <svg class="icon icon-md" viewBox="0 0 24 24">
                        <rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect>
                        <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
                    </svg>
                </div>
                <h3>02. Secure Authentication</h3>
                <p>Industry-standard password hashing (bcrypt) and prepared SQL queries safeguard user credentials.</p>
            </div>

            <!-- 03 Student Dashboard -->
            <div class="feature-card amber">
                <div class="feature-icon-wrap" style="color: var(--accent);">
                    <svg class="icon icon-md" viewBox="0 0 24 24">
                        <rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect>
                        <line x1="3" y1="9" x2="21" y2="9"></line>
                        <line x1="9" y1="21" x2="9" y2="9"></line>
                    </svg>
                </div>
                <h3>03. Student Dashboard</h3>
                <p>View your complete account overview, status badges, and registration details from a unified portal.</p>
            </div>

            <!-- 04 Profile Management -->
            <div class="feature-card muted">
                <div class="feature-icon-wrap" style="color: var(--fg);">
                    <svg class="icon icon-md" viewBox="0 0 24 24">
                        <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                        <circle cx="12" cy="7" r="4"></circle>
                    </svg>
                </div>
                <h3>04. Profile Management</h3>
                <p>Keep your contact details up to date with real-time MySQL profile editing and validation.</p>
            </div>
        </div>
    </div>
</section>

<!-- ══════════════════════════════════════════════════════════════
     4. HOW IT WORKS SECTION
     ══════════════════════════════════════════════════════════════ -->
<section class="landing-section how-section" id="how-it-works">
    <div class="container-wide">
        <div class="section-header">
            <span class="badge badge-dark" style="margin-bottom: 12px; background: rgba(255,255,255,0.1); color: rgba(255,255,255,0.8);">Simple Workflow</span>
            <h2>How It Works</h2>
            <p class="subtitle">Experience an intuitive, frictionless student journey from start to finish.</p>
        </div>

        <div class="steps-grid">
            <div class="step-card">
                <div class="step-num">01</div>
                <h3>Create your account.</h3>
                <p>Fill in your full name, email, and password. The system verifies input and hashes your password securely.</p>
            </div>

            <div class="step-card">
                <div class="step-num">02</div>
                <h3>Sign in securely.</h3>
                <p>Authenticate with your email and password to start a protected PHP session with role guards.</p>
            </div>

            <div class="step-card">
                <div class="step-num">03</div>
                <h3>Access your student dashboard.</h3>
                <p>View your account overview, manage your profile data, and securely log out when finished.</p>
            </div>
        </div>
    </div>
</section>

<!-- ══════════════════════════════════════════════════════════════
     5. BENEFITS SECTION (Emerald Color Block)
     ══════════════════════════════════════════════════════════════ -->
<section class="landing-section benefits-section" id="benefits">
    <div class="container-wide">
        <div class="section-header">
            <span class="badge badge-dark" style="margin-bottom: 12px; background: rgba(255,255,255,0.2); color: #FFFFFF;">Why Student System</span>
            <h2>Built for a Simple Student Experience</h2>
            <p class="subtitle">Engineered with purposeful reduction, strict grid alignment, and instant feedback.</p>
        </div>

        <div class="benefits-grid">
            <div class="benefit-item">
                <div class="benefit-icon-box">
                    <svg class="icon icon-md" viewBox="0 0 24 24">
                        <polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"></polygon>
                    </svg>
                </div>
                <div>
                    <div class="benefit-text">Fast & Responsive</div>
                    <p style="color: rgba(255,255,255,0.8); font-size: 0.88rem; margin: 0;">Blazing fast load times with zero heavy frontend bundle dependencies.</p>
                </div>
            </div>

            <div class="benefit-item">
                <div class="benefit-icon-box">
                    <svg class="icon icon-md" viewBox="0 0 24 24">
                        <circle cx="12" cy="12" r="10"></circle>
                        <polygon points="16.24 7.76 14.12 14.12 7.76 16.24 9.88 9.88 16.24 7.76"></polygon>
                    </svg>
                </div>
                <div>
                    <div class="benefit-text">Simple Navigation</div>
                    <p style="color: rgba(255,255,255,0.8); font-size: 0.88rem; margin: 0;">Clear layout hierarchy that keeps essential student tools at your fingertips.</p>
                </div>
            </div>

            <div class="benefit-item">
                <div class="benefit-icon-box">
                    <svg class="icon icon-md" viewBox="0 0 24 24">
                        <rect x="2" y="3" width="20" height="14" rx="2" ry="2"></rect>
                        <line x1="8" y1="21" x2="16" y2="21"></line>
                        <line x1="12" y1="17" x2="12" y2="21"></line>
                    </svg>
                </div>
                <div>
                    <div class="benefit-text">Multi-Device Support</div>
                    <p style="color: rgba(255,255,255,0.8); font-size: 0.88rem; margin: 0;">Flawless layout adaptation across desktop, tablet, and mobile browsers.</p>
                </div>
            </div>

            <div class="benefit-item">
                <div class="benefit-icon-box">
                    <svg class="icon icon-md" viewBox="0 0 24 24">
                        <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                        <polyline points="14 2 14 8 20 8"></polyline>
                        <line x1="16" y1="13" x2="8" y2="13"></line>
                        <line x1="16" y1="17" x2="8" y2="17"></line>
                    </svg>
                </div>
                <div>
                    <div class="benefit-text">Organized Information</div>
                    <p style="color: rgba(255,255,255,0.8); font-size: 0.88rem; margin: 0;">Structured database records stored safely with utf8mb4 encoding.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ══════════════════════════════════════════════════════════════
     6. ABOUT / MEET THE TEAM SECTION (4 Equal-Sized Flat Cards)
     ══════════════════════════════════════════════════════════════ -->
<section class="landing-section team-section" id="team">
    <div class="container-wide">
        <div class="section-header">
            <span class="badge badge-blue" style="margin-bottom: 12px;">Project Group</span>
            <h2>Meet the Team</h2>
            <p class="subtitle">Developed by our project group for the Student Registration System.</p>
        </div>

        <div class="team-grid">
            <!-- Member 1: Francis Tabuzo Jr. -->
            <div class="team-card">
                <div class="team-avatar">FT</div>
                <div class="team-name">Francis Tabuzo Jr.</div>
            </div>

            <!-- Member 2: Arus Sta Rosa -->
            <div class="team-card">
                <div class="team-avatar">AS</div>
                <div class="team-name">Arus Sta Rosa</div>
            </div>

            <!-- Member 3: Rohn Bon -->
            <div class="team-card">
                <div class="team-avatar">RB</div>
                <div class="team-name">Rohn Bon</div>
            </div>

            <!-- Member 4: Dave Emmanuel Hore -->
            <div class="team-card">
                <div class="team-avatar">DH</div>
                <div class="team-name">Dave Emmanuel Hore</div>
            </div>
        </div>
    </div>
</section>

<!-- ══════════════════════════════════════════════════════════════
     7. CALL TO ACTION SECTION (Amber Block)
     ══════════════════════════════════════════════ -->
<section class="cta-section">
    <div class="container-wide">
        <h2>Ready to get started?</h2>
        <p class="subtitle">Join the Student Registration System today and manage your student profile with ease.</p>
        <a href="register.php" class="btn btn-dark">Create Your Account</a>
    </div>
</section>

<!-- ══════════════════════════════════════════════════════════════
     8. FOOTER
     ══════════════════════════════════════════════════════════════ -->
<footer class="landing-footer">
    <div class="container-wide">
        <div class="footer-grid">
            <div>
                <div class="footer-brand">
                    <svg class="icon icon-md" viewBox="0 0 24 24" style="color: var(--primary); display:inline; margin-right:6px;">
                        <path d="M22 10v6M2 10l10-5 10 5-10 5z"></path>
                        <path d="M6 12v5c3 3 9 3 12 0v-5"></path>
                    </svg>
                    Student System
                </div>
                <p class="footer-desc">A modern, secure student registration and profile management portal engineered with PHP, MySQL, and pure Flat Design principles.</p>
            </div>
            <div>
                <div class="footer-heading">Navigation</div>
                <ul class="footer-links">
                    <li><a href="#home">Home</a></li>
                    <li><a href="#features">Features</a></li>
                    <li><a href="#how-it-works">How It Works</a></li>
                    <li><a href="#benefits">Benefits</a></li>
                    <li><a href="#team">Team</a></li>
                </ul>
            </div>
            <div>
                <div class="footer-heading">Portal Access</div>
                <ul class="footer-links">
                    <li><a href="login.php">Sign In</a></li>
                    <li><a href="register.php">Create Account</a></li>
                    <li><a href="dashboard.php">Dashboard</a></li>
                </ul>
            </div>
        </div>
        <div class="footer-bottom">
            &copy; <?= date("Y") ?> Student Registration System. All rights reserved. Built for College Group Project Presentation.
        </div>
    </div>
</footer>

<script src="js/script.js"></script>
</body>
</html>
