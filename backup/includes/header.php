<?php
if (session_status() === PHP_SESSION_NONE) session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title><?= $page_title ?? 'Wazuh Security Lab'; ?></title>

<link rel="stylesheet" href="/assets/css/style.css">

<style>
/* ===== BASE ===== */
body {
    margin: 0;
    background: #050b1e;
    font-family: 'Segoe UI', system-ui, sans-serif;
}

/* ===== NAVBAR ===== */
.navbar {
    background: linear-gradient(135deg, #050b1e, #0a1b3d);
    height: 64px;
    padding: 0 28px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    border-bottom: 1px solid rgba(255,255,255,.08);
}

/* ===== BRAND (LEFT) ===== */
.nav-left {
    display: flex;
    align-items: center;
}

.nav-left .brand {
    display: flex;
    align-items: center;
    gap: 10px;
    text-decoration: none;
}

.nav-left .logo {
    font-size: 22px;
    line-height: 1;
    color: #5da9ff;
}

.nav-left .title {
    font-size: 16px;
    font-weight: 600;
    color: #ffffff;
    white-space: nowrap;
}

/* ===== CENTER MENU ===== */
.nav-center ul {
    list-style: none;
    display: flex;
    gap: 24px;
    margin: 0;
    padding: 0;
    align-items: center;
}

.nav-center ul li {
    position: relative;
}

.nav-center ul li a {
    color: #b8c7ff;
    font-size: 14px;
    text-decoration: none;
    padding-bottom: 6px;
    transition: .2s;
}

.nav-center ul li a:hover {
    color: #ffffff;
}

/* ACTIVE INDICATOR */
.nav-center ul li a.active::after,
.nav-center ul li a:hover::after {
    content: '';
    position: absolute;
    bottom: -6px;
    left: 0;
    width: 100%;
    height: 2px;
    background: #5da9ff;
    border-radius: 5px;
}

/* ===== DROPDOWN ===== */
.dropdown-menu {
    position: absolute;
    top: 36px;
    left: 0;
    background: rgba(10, 20, 50, 0.95);
    backdrop-filter: blur(8px);
    border: 1px solid rgba(255,255,255,.08);
    border-radius: 8px;
    min-width: 180px;
    list-style: none;
    padding: 8px 0;
    opacity: 0;
    visibility: hidden;
    transform: translateY(10px);
    transition: .25s ease;
    z-index: 1000;
}

.dropdown-menu li a {
    display: block;
    padding: 10px 16px;
    font-size: 13px;
    color: #b8c7ff;
}

.dropdown-menu li a:hover {
    background: rgba(93,169,255,.15);
    color: #ffffff;
}

.dropdown:hover .dropdown-menu {
    opacity: 1;
    visibility: visible;
    transform: translateY(0);
}

/* ===== RIGHT (LOGIN / LOGOUT) ===== */
.nav-right a {
    padding: 8px 16px;
    border-radius: 6px;
    font-size: 13px;
    text-decoration: none;
    transition: .2s;
}

.login-btn {
    border: 1px solid #5da9ff;
    color: #5da9ff;
}

.login-btn:hover {
    background: #5da9ff;
    color: #000;
}

.logout-btn {
    background: #ff4d4d;
    color: #fff;
}

.logout-btn:hover {
    opacity: .85;
}

/* ===== RESPONSIVE ===== */
@media (max-width: 900px) {
    .nav-center ul {
        gap: 16px;
    }
}

@media (max-width: 768px) {
    .nav-center {
        display: none;
    }

    .navbar {
        padding: 0 16px;
    }

    .nav-left .title {
        font-size: 14px;
    }
}

</style>
</head>

<body>

    <header class="navbar">

        <!-- LEFT -->
        <div class="nav-left">
            <a href="/index.php" class="brand">
                <span class="logo">🛡️</span>
                <span class="title">Wazuh Security Lab</span>
            </a>
        </div>


        <!-- CENTER -->
        <nav class="nav-center">
            <ul>
                <li><a href="/index.php" class="<?= $active=='dashboard'?'active':'' ?>">Dashboard</a></li>
                <li><a href="/lab/" class="<?= $active=='lab'?'active':'' ?>">Lab</a></li>
                <li class="dropdown">
                    <a href="#" class="<?= $active=='tools'?'active':'' ?>">Tools ▾</a>
                    <ul class="dropdown-menu">
                        <li><a href="/tools/osint/">OSINT</a></li>
                        <li><a href="/tools/scanner/">Scanner</a></li>
                        <li><a href="/tools/log-analyzer/">Log Analyzer</a></li>
                        <li><a href="/tools/forensics/">Forensics</a></li>
                        <li><a href="/tools/malware/">Malware Lab</a></li>
                    </ul>
                </li>

                <li><a href="/search/" class="<?= $active=='search'?'active':'' ?>">Search</a></li>
                <li><a href="/files/" class="<?= $active=='files'?'active':'' ?>">Files</a></li>
                <li><a href="/profile/" class="<?= $active=='profile'?'active':'' ?>">Profile</a></li>

                <?php if (!empty($_SESSION['is_admin'])): ?>
                    <li><a href="/admin/">Admin</a></li>
                <?php endif; ?>
            </ul>
        </nav>

        <!-- RIGHT -->
        <div class="nav-right">
            <?php if (!empty($_SESSION['user'])): ?>
                <a href="/auth/logout.php" class="logout-btn">Logout</a>
            <?php else: ?>
                <a href="/auth/login.php" class="login-btn">Login</a>
            <?php endif; ?>
        </div>

    </header>
</body>