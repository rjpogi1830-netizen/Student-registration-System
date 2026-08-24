STUDENT REGISTRATION AND LOGIN SYSTEM
======================================

A modern, secure student registration portal and account management system
built with PHP, MySQL, CSS3, and Vanilla JavaScript.

PROJECT GROUP MEMBERS:
- Francis Tabuzo Jr.
- Arus Sta Rosa
- Rohn Bon
- Dave Emmanuel Hore

SYSTEM REQUIREMENTS:
- XAMPP (Apache + MySQL)
- PHP 7.4+ / PHP 8.x
- MySQL 5.7+ / MariaDB
- Any modern web browser (Chrome, Firefox, Edge, Safari)

LOCAL INSTALLATION:
1. Ensure the "student_registration_system" directory is located in:
   C:\xampp\htdocs\student_registration_system\

2. Launch the XAMPP Control Panel and START:
   - Apache
   - MySQL

3. Database Configuration:
   - The database name is `student_system`
   - If not yet imported, open phpMyAdmin at http://localhost/phpmyadmin/
   - Import `database.sql` to generate the `users` table automatically.

4. Access the Application:
   http://localhost/student_registration_system/

DATABASE CREDENTIALS:
Located in `config/database.php`:
Host:     localhost
Database: student_system
Username: root
Password: (empty by default on XAMPP)

PROJECT PAGES & ARCHITECTURE:
- index.php        → Landing page with 8 sections (Hero, Features, How It Works,
                     Benefits, Meet the Team, CTA, and Footer)
- register.php     → Split-screen student registration with live validation & strength meter
- login.php        → Split-screen sign-in with password toggle & session creation
- dashboard.php    → Student Portal Dashboard with sidebar navigation & real database metrics
- profile.php      → Student Profile view and authentic MySQL profile editor
- logout.php       → Secure session destruction and redirection handler

CSS DESIGN SYSTEM:
- css/style.css    → Pure Flat Design system: Outfit font, zero box-shadows, color blocks,
                     interactive scale-hover effects, team grid, and responsive breakpoints.

JAVASCRIPT UX:
- js/script.js     → Password show/hide toggle, real-time password strength meter,
                     confirm password validation, mobile sidebar/nav toggles,
                     smooth scrolling with ScrollSpy, and dismissible alerts.

SECURITY PRACTICES IMPLEMENTED:
- Passwords securely hashed with Bcrypt via password_hash()
- Authentication verified using password_verify()
- All database queries execute via Prepared Statements (SQL Injection Prevention)
- Dynamic outputs escaped with htmlspecialchars() (XSS Prevention)
- Protected pages guarded by active PHP session validation
- Email uniqueness validation on both registration and profile editing
