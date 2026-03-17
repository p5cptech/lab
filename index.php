<?php
// index.php - Dashboard Navigasi Lab Pentest
session_start();
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>mrahmatt74 Security Lab | Dashboard</title>
    <link rel="stylesheet" href="public/assets/main.css">
    <link rel="stylesheet" href="public/assets/style.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body>

<nav class="navbar">
    <a href="index.php" class="nav-logo">
        <i class="fas fa-shield-virus"></i> mrahmatt74.LAB
    </a>
    <ul class="nav-links">
        <li><a href="index.php" class="active"><i class="fas fa-home"></i> Dashboard</a></li>
        <li><a href="profile.php"><i class="fas fa-user-circle"></i> Profile</a></li>
        <li><a href="login.php"><i class="fas fa-sign-in-alt"></i> Login</a></li>
        <li><a href="https://192.168.5.82:8443" target="_blank" class="btn-siem"><i class="fas fa-radar"></i> SIEM Console</a></li>
    </ul>
</nav>

<header>
    <h1>Pentest Lab Dashboard</h1>
    <p>Security Awareness & Vulnerability Research Environment</p>
</header>

<div class="container">
    <div class="lab-grid">
        
        <div class="category-card">
            <div class="category-header">
                <i class="fas fa-syringe"></i>
                <h3>Injection</h3>
            </div>
            <ul class="module-list">
                <li><a href="modules/injection/sqli.php">SQL Injection <i class="fas fa-chevron-right"></i></a></li>
                <li><a href="modules/injection/cmd_injection.php">OS Command Injection <i class="fas fa-chevron-right"></i></a></li>
                <li><a href="modules/injection/ssti.php">SSTI <i class="fas fa-chevron-right"></i></a></li>
                <li><a href="register.php">Vulnerable Register <span class="badge">Core</span></a></li>
            </ul>
        </div>

        <div class="category-card">
            <div class="category-header">
                <i class="fas fa-user-lock"></i>
                <h3>Broken Auth & Access</h3>
            </div>
            <ul class="module-list">
                <li><a href="modules/broken_auth/jwt_lab.php">JWT & OAuth Lab <i class="fas fa-chevron-right"></i></a></li>
                <li><a href="modules/broken_auth/auth_bypass.php">Authentication Bypass <i class="fas fa-chevron-right"></i></a></li>
            </ul>
        </div>

        <div class="category-card">
            <div class="category-header">
                <i class="fas fa-laptop-code"></i>
                <h3>Client Side Attacks</h3>
            </div>
            <ul class="module-list">
                <li><a href="modules/client_side/xss_reflected.php">Reflected XSS <i class="fas fa-chevron-right"></i></a></li>
                <li><a href="modules/client_side/csrf_lab.php">CSRF Lab <i class="fas fa-chevron-right"></i></a></li>
            </ul>
        </div>

        <div class="category-card">
            <div class="category-header">
                <i class="fas fa-server"></i>
                <h3>Server Side Attacks</h3>
            </div>
            <ul class="module-list">
                <li><a href="modules/server_side/ssrf.php">SSRF <i class="fas fa-chevron-right"></i></a></li>
                <li><a href="modules/server_side/path_traversal.php">Path Traversal <i class="fas fa-chevron-right"></i></a></li>
            </ul>
        </div>

        <div class="category-card">
            <div class="category-header">
                <i class="fas fa-cloud"></i>
                <h3>API & Disclosure</h3>
            </div>
            <ul class="module-list">
                <li><a href="modules/api/testing.php">API Testing <i class="fas fa-chevron-right"></i></a></li>
                <li><a href="logs/pentest_access.log" target="_blank">Access Logs <span class="badge" style="background:#00a9e0">Wazuh Target</span></a></li>
            </ul>
        </div>

    </div>
</div>

<footer>
    &copy; 2026 mrahmatt74 Lab - ADR Group Infrastructure Security
</footer>

</body>
</html>