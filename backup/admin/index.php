<?php 
require('../config/db.php'); 

// Statistik Data
$q_blog  = mysqli_query($conn, "SELECT COUNT(*) as total FROM blog_posts");
$res_blog = mysqli_fetch_assoc($q_blog);

$q_user  = mysqli_query($conn, "SELECT COUNT(*) as total FROM users");
$res_user = mysqli_fetch_assoc($q_user);

$total_tools = 5; 
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Wazuh Lab System</title>
    <style>
        /* AUTHENTIC WINDOWS 95 / CLASSIC THEME */
        :root {
            --win-grey: #c0c0c0;
            --win-blue: #000080;
            --win-border-light: #ffffff;
            --win-border-dark: #808080;
            --win-border-black: #000000;
        }

        * { margin: 0; padding: 0; box-sizing: border-box; font-family: "MS Sans Serif", "Tahoma", sans-serif; font-size: 12px; }

        body {
            background-color: #008080; /* Teal klasik Desktop Windows lama */
            color: #000;
            padding: 20px;
        }

        /* Nav Bar / Taskbar Look */
        .navbar {
            background: var(--win-grey);
            border: 2px solid;
            border-color: var(--win-border-light) var(--win-border-dark) var(--win-border-dark) var(--win-border-light);
            padding: 4px 10px;
            margin-bottom: 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        /* Window Container */
        .window {
            background: var(--win-grey);
            border: 2px solid;
            border-color: var(--win-border-light) var(--win-border-black) var(--win-border-black) var(--win-border-light);
            box-shadow: 1px 1px 0 0 #000;
            max-width: 1000px;
            margin: 0 auto;
        }

        .window-header {
            background: var(--win-blue);
            color: white;
            padding: 3px 6px;
            font-weight: bold;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .window-body { padding: 15px; }

        .welcome-area {
            background: white;
            border: 2px inset;
            padding: 10px;
            margin-bottom: 20px;
        }

        /* Stat Cards */
        .grid-stats {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 15px;
            margin-bottom: 20px;
        }

        .stat-card {
            background: var(--win-grey);
            border: 2px solid;
            border-color: var(--win-border-light) var(--win-border-dark) var(--win-border-dark) var(--win-border-light);
            padding: 10px;
        }

        .stat-card h2 { font-size: 11px; margin-bottom: 10px; text-decoration: underline; }

        .stat-card .value {
            font-size: 32px;
            background: #fff;
            border: 2px inset;
            display: block;
            text-align: right;
            padding: 5px 10px;
            margin-bottom: 10px;
            font-family: 'Courier New', monospace;
            font-weight: bold;
        }

        /* Classic Buttons */
        .btn-retro {
            background: var(--win-grey);
            border: 2px solid;
            border-color: var(--win-border-light) var(--win-border-black) var(--win-border-black) var(--win-border-light);
            padding: 4px 12px;
            text-decoration: none;
            color: #000;
            display: inline-block;
            text-align: center;
        }

        .btn-retro:active {
            border-color: var(--win-border-black) var(--win-border-light) var(--win-border-light) var(--win-border-black);
            padding: 5px 11px 3px 13px;
        }

        /* Quick Access */
        .tools-area {
            border: 1px solid var(--win-border-dark);
            padding: 10px;
            margin-top: 20px;
        }

        .tool-link {
            color: blue;
            margin-right: 15px;
            text-decoration: underline;
            cursor: pointer;
        }

        footer {
            margin-top: 20px;
            text-align: center;
            color: white;
            font-size: 10px;
        }
    </style>
</head>
<body>

<div class="navbar">
    <strong>Wazuh_Lab_Manager</strong>
    <span>System Time: <?php echo date('H:i:s'); ?></span>
</div>

<div class="window">
    <div class="window-header">
        <span>Admin_Dashboard.exe</span>
        <div style="background:var(--win-grey); width: 14px; height: 14px; border:1px solid #000; color:#000; text-align:center; line-height:10px; cursor:pointer;">x</div>
    </div>
    
    <div class="window-body">
        <div class="welcome-area">
            <h1 style="font-size: 16px;">Control Panel</h1>
            <p>Welcome back, Administrator. All security systems are operational.</p>
        </div>

        <div class="grid-stats">
            <div class="stat-card">
                <h2>Total_Articles</h2>
                <span class="value"><?= $res_blog['total']; ?></span>
                <a href="../blog/index.php" class="btn-retro">Manage...</a>
            </div>

            <div class="stat-card">
                <h2>Registered_Users</h2>
                <span class="value"><?= $res_user['total']; ?></span>
                <a href="users.php" class="btn-retro">Explore...</a>
            </div>

            <div class="stat-card">
                <h2>Lab_Tools</h2>
                <span class="value"><?= $total_tools; ?></span>
                <a href="../tools/index.php" class="btn-retro">Launch...</a>
            </div>
        </div>

        <fieldset class="tools-area">
            <legend>Quick Lab Access</legend>
            <div style="padding: 5px;">
                <a href="../tools/net-check.php" class="tool-link">Network_Check</a>
                <a href="../tools/net.php" class="tool-item tool-link">Scanner</a>
                <a href="blog_add.php" class="tool-link">New_Post</a>
                <a href="../logout.php" class="tool-link" style="color: red;">Exit_System</a>
            </div>
        </fieldset>
    </div>
</div>

<footer>
    &copy; 1995-2024 Wazuh Security Lab Corporation
</footer>

</body>
</html>