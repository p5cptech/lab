<?php
// index.php - Dashboard Navigasi Lab Pentest Komprehensif
session_start();

/**
 * ACCESS CONTROL MRAHMATT74.LAB
 * Jika tidak ada Cookie user_session ATAU user_auth ATAU Session username, 
 * maka dilempar ke login.php
 */
if (!isset($_COOKIE['user_session']) && !isset($_COOKIE['user_auth']) && !isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}
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
    <style>
        :root { --primary-green: #285A48; --dark-green: #1a3c30; }
        .badge-new { background: #e67e22; color: white; padding: 2px 6px; border-radius: 4px; font-size: 0.7rem; font-weight: bold; }
        .badge-danger { background: #d32f2f; color: white; padding: 2px 6px; border-radius: 4px; font-size: 0.7rem; font-weight: bold; }
        .category-card { height: 100%; display: flex; flex-direction: column; transition: transform 0.2s; }
        .category-card:hover { transform: translateY(-5px); }
        .module-list { flex-grow: 1; list-style: none; padding: 15px; margin: 0; }
        .module-list li { margin-bottom: 10px; border-bottom: 1px solid #eee; padding-bottom: 5px; }
        .module-list li a { text-decoration: none; color: #333; display: flex; justify-content: space-between; align-items: center; font-size: 0.9rem; }
        .module-list li a:hover { color: var(--primary-green); }
        .btn-siem { background: #d32f2f !important; }
        header { background: var(--primary-green) !important; padding: 40px 0; color: white; text-align: center; }
    </style>
</head>
<body>

<nav class="navbar">
    <a href="index.php" class="nav-logo">
        <i class="fas fa-shield-halved"></i> mrahmatt74.LAB
    </a>
    <ul class="nav-links">
        <li><a href="index.php" class="active"><i class="fas fa-home"></i> Dashboard</a></li>
        
        <li><a href="profile.php"><i class="fas fa-user-circle"></i> Profile</a></li>
        <li><a href="logout.php" style="color: #ff4d4d;"><i class="fas fa-sign-out-alt"></i> Logout</a></li>

        <li><a href="https://192.168.5.82:8443" target="_blank" class="btn-siem"><i class="fas fa-radar"></i> SIEM Console</a></li>
    </ul>
</nav>

<header>
    <h1>Cybersecurity Research Lab</h1>
    <p>Infrastructure Vulnerability Assessment • Muhammad Rahmat • 2026</p>
</header>

<div class="container" style="margin-top: 30px;">
    <div class="lab-grid" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 20px;">
        
        <div class="category-card">
            <div class="category-header" style="background: var(--dark-green); color: white; padding: 15px;">
                <i class="fas fa-skull-crossbones"></i> Advanced Attacks
            </div>
            <ul class="module-list">
                <li><a href="modules/advanced/upload.php">Unrestricted Upload <span class="badge-danger">RCE</span></a></li>
                <li><a href="modules/advanced/race_cond.php">Race Condition <i class="fas fa-stopwatch"></i></a></li>
                <li><a href="modules/advanced/cache_poison.php">Web Cache Poisoning <i class="fas fa-vial"></i></a></li>
                <li><a href="modules/advanced/smuggling.php">HTTP Request Smuggling <i class="fas fa-random"></i></a></li>
                <li><a href="modules/advanced/proto_pollute.php">Prototype Pollution <i class="fas fa-atom"></i></a></li>
            </ul>
        </div>

        <div class="category-card">
            <div class="category-header" style="background: var(--primary-green); color: white; padding: 15px;">
                <i class="fas fa-laptop-code"></i> Client Side
            </div>
            <ul class="module-list">
                <li><a href="modules/client_side/xss.php">Cross-site Scripting (XSS) <i class="fas fa-chevron-right"></i></a></li>
                <li><a href="modules/client_side/xss_reflected.php">Reflected XSS <i class="fas fa-chevron-right"></i></a></li>
                <li><a href="modules/client_side/xss_stored.php">Stored XSS <i class="fas fa-chevron-right"></i></a></li>
                <li><a href="modules/client_side/xss_blind.php">Blind XSS <i class="fas fa-chevron-right"></i></a></li>
                <li><a href="modules/client_side/csrf_lab.php">CSRF Lab <i class="fas fa-chevron-right"></i></a></li>
                <li><a href="modules/client_side/dom_vuln.php">DOM-based Vuln <i class="fas fa-chevron-right"></i></a></li>
                <li><a href="modules/client_side/cors_misconfig.php">CORS Misconfig <i class="fas fa-chevron-right"></i></a></li>
            </ul>
        </div>

        <div class="category-card">
            <div class="category-header" style="background: var(--primary-green); color: white; padding: 15px;">
                <i class="fas fa-syringe"></i> Injections
            </div>
            <ul class="module-list">
                <li><a href="modules/injection/sqli.php">SQL Injection <i class="fas fa-database"></i></a></li>
                <li><a href="modules/injection/cmd_injection.php">OS Command Injection <i class="fas fa-terminal"></i></a></li>
                <li><a href="modules/injection/ssti.php">SSTI <i class="fas fa-chevron-right"></i></a></li>
            </ul>
        </div>

        <div class="category-card">
            <div class="category-header" style="background: var(--primary-green); color: white; padding: 15px;">
                <i class="fas fa-user-lock"></i> Authentication
            </div>
            <ul class="module-list">
                <li><a href="modules/broken_auth/auth_bypass.php">Auth Bypass <i class="fas fa-chevron-right"></i></a></li>
                <li><a href="modules/broken_auth/jwt_lab.php">JWT Laboratory <i class="fas fa-chevron-right"></i></a></li>
                <li><a href="modules/broken_auth/insecure_des.php">Insecure Deserialization <i class="fas fa-chevron-right"></i></a></li>
            </ul>
        </div>

        <div class="category-card">
            <div class="category-header" style="background: var(--primary-green); color: white; padding: 15px;">
                <i class="fas fa-server"></i> Server Side
            </div>
            <ul class="module-list">
                <li><a href="modules/server_side/ssrf.php">Server-Side Request Forgery <i class="fas fa-chevron-right"></i></a></li>
                <li><a href="modules/server_side/xxe.php">XML External Entity (XXE) <i class="fas fa-chevron-right"></i></a></li>
                <li><a href="modules/server_side/path_traversal.php">Path Traversal <i class="fas fa-chevron-right"></i></a></li>
                <li><a href="modules/server_side/host_header.php">Host Header Attack <i class="fas fa-chevron-right"></i></a></li>
            </ul>
        </div>

        <div class="category-card">
            <div class="category-header" style="background: var(--primary-green); color: white; padding: 15px;">
                <i class="fas fa-cloud"></i> API & Monitoring
            </div>
            <ul class="module-list">
                <li><a href="modules/api/v1/">REST API v1 Endpoints <span class="badge-new">NEW</span></a></li>
                <li><a href="modules/api/testing.php">API Testing Utility <i class="fas fa-chevron-right"></i></a></li>
                <li><a href="logs/pentest_access.log" target="_blank">Wazuh Access Logs <span class="badge" style="background:#00a9e0">SIEM</span></a></li>
            </ul>
        </div>

    </div>
</div>

<footer>
    &copy; 2026 mrahmatt74 Lab - ADR Group Infrastructure Security • 
    <span style="color: #ffca28">Wazuh SIEM Integrated Environment</span>
</footer>

</body>
</html>