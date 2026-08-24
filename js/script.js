/* ══════════════════════════════════════════════════════════════
   STUDENT REGISTRATION SYSTEM — INTERACTIVE JAVASCRIPT UX ENGINE
   ══════════════════════════════════════════════════════════════ */

document.addEventListener("DOMContentLoaded", function () {

    /* ── 1. Password Visibility Toggle (Show / Hide) ── */
    const passwordToggles = document.querySelectorAll(".password-toggle-btn");
    passwordToggles.forEach(function (btn) {
        btn.addEventListener("click", function () {
            const targetId = this.getAttribute("data-target");
            const input = document.getElementById(targetId);
            if (!input) return;

            const isPassword = input.type === "password";
            input.type = isPassword ? "text" : "password";
            this.setAttribute("aria-label", isPassword ? "Hide password" : "Show password");

            // Toggle SVG icon between Eye and Eye-Off
            if (isPassword) {
                this.innerHTML = `
                    <svg class="icon icon-sm" viewBox="0 0 24 24">
                        <path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"></path>
                        <line x1="1" y1="1" x2="23" y2="23"></line>
                    </svg>`;
            } else {
                this.innerHTML = `
                    <svg class="icon icon-sm" viewBox="0 0 24 24">
                        <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                        <circle cx="12" cy="12" r="3"></circle>
                    </svg>`;
            }
        });
    });

    /* ── 2. Password Strength Meter (Registration) ── */
    const passwordInput = document.getElementById("password");
    const strengthMeter = document.getElementById("strengthMeter");
    const strengthLabel = document.getElementById("strengthLabel");

    if (passwordInput && strengthMeter) {
        passwordInput.addEventListener("input", function () {
            const val = this.value;
            let score = 0;

            if (val.length >= 6) score++;
            if (val.length >= 8) score++;
            if (/[A-Z]/.test(val) && /[a-z]/.test(val)) score++;
            if (/[0-9]/.test(val)) score++;
            if (/[^A-Za-z0-9]/.test(val)) score++;

            strengthMeter.className = "strength-meter";

            if (val.length === 0) {
                strengthLabel.textContent = "Enter a password";
            } else if (score <= 2) {
                strengthMeter.classList.add("weak");
                strengthLabel.textContent = "Weak password (min. 6 characters)";
            } else if (score <= 4) {
                strengthMeter.classList.add("medium");
                strengthLabel.textContent = "Good password";
            } else {
                strengthMeter.classList.add("strong");
                strengthLabel.textContent = "Strong password!";
            }
        });
    }

    /* ── 3. Real-Time Confirm Password Match ── */
    const confirmInput = document.getElementById("confirm_password");
    const matchError = document.getElementById("matchError");

    function checkPasswordMatch() {
        if (!passwordInput || !confirmInput) return true;
        if (confirmInput.value === "") {
            confirmInput.classList.remove("is-invalid", "is-valid");
            if (matchError) matchError.style.display = "none";
            return false;
        }

        if (passwordInput.value === confirmInput.value) {
            confirmInput.classList.remove("is-invalid");
            confirmInput.classList.add("is-valid");
            if (matchError) matchError.style.display = "none";
            return true;
        } else {
            confirmInput.classList.remove("is-valid");
            confirmInput.classList.add("is-invalid");
            if (matchError) {
                matchError.textContent = "Passwords do not match.";
                matchError.style.display = "block";
            }
            return false;
        }
    }

    if (confirmInput && passwordInput) {
        confirmInput.addEventListener("input", checkPasswordMatch);
        passwordInput.addEventListener("input", function () {
            if (confirmInput.value !== "") checkPasswordMatch();
        });
    }

    /* ── 4. Form Submission & Loading State ── */
    const forms = document.querySelectorAll("form");
    forms.forEach(function (form) {
        form.addEventListener("submit", function (e) {
            if (form.id === "registerForm" && confirmInput) {
                if (passwordInput.value !== confirmInput.value) {
                    e.preventDefault();
                    confirmInput.focus();
                    checkPasswordMatch();
                    return;
                }
            }

            const submitBtn = form.querySelector("button[type='submit']");
            if (submitBtn && !submitBtn.classList.contains("is-loading")) {
                submitBtn.classList.add("is-loading");
                const originalText = submitBtn.innerHTML;
                submitBtn.innerHTML = `<span class="btn-spinner"></span> Processing...`;
            }
        });
    });

    /* ── 5. Alert Notifications: Dismissal & Auto-dismiss ── */
    const alerts = document.querySelectorAll(".alert");
    alerts.forEach(function (alert) {
        const closeBtn = alert.querySelector(".alert-close");
        if (closeBtn) {
            closeBtn.addEventListener("click", function () {
                alert.style.opacity = "0";
                alert.style.transform = "translateY(-8px)";
                setTimeout(function () { alert.remove(); }, 200);
            });
        }

        // Auto-dismiss after 6 seconds
        setTimeout(function () {
            if (document.body.contains(alert)) {
                alert.style.opacity = "0";
                alert.style.transform = "translateY(-8px)";
                setTimeout(function () { alert.remove(); }, 300);
            }
        }, 6000);
    });

    /* ── 6. Portal Mobile Sidebar Toggle ── */
    const portalToggle = document.getElementById("portalMobileToggle");
    const portalSidebar = document.getElementById("portalSidebar");

    if (portalToggle && portalSidebar) {
        portalToggle.addEventListener("click", function () {
            portalSidebar.classList.toggle("open");
        });

        // Close sidebar on click outside on mobile
        document.addEventListener("click", function (e) {
            if (window.innerWidth <= 768 && portalSidebar.classList.contains("open")) {
                if (!portalSidebar.contains(e.target) && !portalToggle.contains(e.target)) {
                    portalSidebar.classList.remove("open");
                }
            }
        });
    }

    /* ── 7. Landing Page: Mobile Nav Toggle & Smooth Scrolling ── */
    const navToggle = document.getElementById("navToggle");
    const landingNav = document.getElementById("landingNav");

    if (navToggle && landingNav) {
        navToggle.addEventListener("click", function () {
            landingNav.classList.toggle("nav-open");
        });

        const navLinks = landingNav.querySelectorAll(".nav-link");
        navLinks.forEach(function (link) {
            link.addEventListener("click", function () {
                landingNav.classList.remove("nav-open");
            });
        });
    }

    // Smooth Scrolling for anchor links with offset
    const anchorLinks = document.querySelectorAll('a[href^="#"]');
    anchorLinks.forEach(function (anchor) {
        anchor.addEventListener("click", function (e) {
            const targetId = this.getAttribute("href");
            if (targetId === "#") return;

            const targetElement = document.querySelector(targetId);
            if (targetElement) {
                e.preventDefault();
                const navHeight = landingNav ? landingNav.offsetHeight : 0;
                const targetPosition = targetElement.getBoundingClientRect().top + window.pageYOffset - navHeight;

                window.scrollTo({
                    top: targetPosition,
                    behavior: "smooth"
                });
            }
        });
    });

    // ScrollSpy for Active Nav Link
    const sections = document.querySelectorAll("section[id], body[id]");
    const navItems = document.querySelectorAll(".nav-center .nav-link");

    if (sections.length > 0 && navItems.length > 0) {
        window.addEventListener("scroll", function () {
            let current = "";
            const scrollY = window.pageYOffset;
            const navHeight = landingNav ? landingNav.offsetHeight + 60 : 80;

            sections.forEach(function (section) {
                const sectionTop = section.offsetTop - navHeight;
                const sectionHeight = section.offsetHeight;
                if (scrollY >= sectionTop && scrollY < sectionTop + sectionHeight) {
                    current = section.getAttribute("id");
                }
            });

            navItems.forEach(function (item) {
                item.classList.remove("active");
                if (item.getAttribute("href") === "#" + current) {
                    item.classList.add("active");
                }
            });
        });
    }
});
