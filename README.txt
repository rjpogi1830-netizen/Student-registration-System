========================================================================
STUDENT REGISTRATION SYSTEM — PORTAL 2.0
========================================================================

A modern, secure student registration and account management web application
built as a comprehensive College Group Project.

LIVE DEMO:
- Live Production Website: https://student-registration-system-j2e6.onrender.com/
- GitHub Repository:       https://github.com/rjpogi1830-netizen/Student-registration-System

PROJECT GROUP MEMBERS:
- Francis Tabuzo Jr.
- Arus Sta Rosa
- Rohn Bon
- Dave Emmanuel Hore

========================================================================
1. COMPLETE TECH STACK
========================================================================
- Backend:           PHP 7.4+ / PHP 8.x (No third-party framework overhead)
- Database:          MySQL 5.7+ / MariaDB (utf8mb4 encoding)
- Frontend Markup:   HTML5 with accessible inline SVG icons
- Styling:           CSS3 Pure Flat Design (Google Font Outfit, zero box-shadows)
- JavaScript:        Vanilla ES6 JavaScript (Password strength meter, show/hide toggles)
- Containerization:  Docker (Official php:8.2-apache image)
- Cloud Host:        Render (Web Service with automatic GitHub CI/CD)
- Cloud Database:    Aiven (Managed MySQL Service)
- Local Dev Server:  XAMPP (Apache + MariaDB + phpMyAdmin)
- Version Control:   Git & GitHub

========================================================================
2. ABOUT THE APPLICATION & PAGES
========================================================================
- index.php          → Premium landing page with 8 sections: Navigation,
                       Hero with system preview mockup, 4 Features, 3 Step
                       How-It-Works workflow, Emerald Benefits, Meet the Team
                       section with the 4 group members, Amber CTA, and dark footer.
- register.php       → Split-screen registration with real-time password strength
                       scoring, show/hide password toggles, confirm password validation,
                       input retention on error, and bcrypt hashing.
- login.php          → Split-screen sign-in with password toggle, preserved email,
                       and flash success notification.
- dashboard.php      → Student portal dashboard with sidebar navigation, active
                       session indicator, greeting banner, 3 live stat cards (real
                       "Member Since" date from MySQL), and strictly genuine fields:
                       Account ID (#ACC-0000{id}), Full Name, Email, Registration Date.
- profile.php        → Student profile details card + authentic MySQL edit form
                       allowing students to update their name and email directly.
- logout.php         → Secure session unset, destroy, and redirection handler.

========================================================================
3. SECURITY PRACTICES
========================================================================
- Passwords encrypted with Bcrypt via password_hash() and password_verify()
- 100% Prepared SQL Statements ($stmt->bind_param) to prevent SQL Injection
- HTML output sanitized with htmlspecialchars() to prevent Cross-Site Scripting (XSS)
- Session validation guards on all protected portal pages
- Duplicate email prevention on both registration and profile editing

========================================================================
4. HOW WE DEPLOYED IT (RENDER + AIVEN)
========================================================================
1. Aiven Cloud MySQL:
   - Created a free MySQL service on https://aiven.io/
   - Obtained connection parameters: Host, Port, User, Password, Database.

2. Docker Containerization:
   - Configured Dockerfile using php:8.2-apache with mysqli extension.

3. Render Cloud Web Service:
   - Connected GitHub repository https://github.com/rjpogi1830-netizen/Student-registration-System
   - Configured Runtime: Docker
   - Added Environment Variables:
     DB_HOST, DB_PORT, DB_USER, DB_PASS, DB_NAME
   - Live URL: https://student-registration-system-j2e6.onrender.com/
   - Render automatically builds and deploys on every push to main.

========================================================================
5. LOCAL INSTALLATION (XAMPP)
========================================================================
1. Place project in: C:\xampp\htdocs\student_registration_system\
2. Start Apache and MySQL in XAMPP Control Panel.
3. Import database.sql in phpMyAdmin.
4. Access website at: http://localhost/student_registration_system/

========================================================================
GitHub Repository: https://github.com/rjpogi1830-netizen/Student-registration-System
Live Website URL:  https://student-registration-system-j2e6.onrender.com/
Branch: main
========================================================================
