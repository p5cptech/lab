<?php
// Koneksi ke database
require('../config/db.php');

// 1. Logika Pencarian
// Mengambil input dari parameter URL 'q'. Jika kosong, diisi string kosong.
$q = isset($_GET['q']) ? $_GET['q'] : '';

// 2. Query Database
// Jika ada keyword, cari di kolom 'title' atau 'content'. Jika tidak, tampilkan semua.
if ($q !== '') {
    // VULNERABILITY NOTE: Baris di bawah ini sengaja dibuat rentan SQL Injection untuk Lab Pentest.
    // Gunakan mysqli_real_escape_string() atau Prepared Statements untuk memperbaikinya.
    $sql = "SELECT * FROM blog_posts WHERE title LIKE '%$q%' OR content LIKE '%$q%' ORDER BY id DESC";
} else {
    $sql = "SELECT * FROM blog_posts ORDER BY id DESC";
}

$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Blog | Wazuh Security Lab</title>
    <style>
        /* ===== CSS STYLING (WAZUH DARK THEME) ===== */
        :root {
            --bg-body: #050b1e;
            --bg-header: #0a1b3d;
            --accent: #5da9ff;
            --text-main: #ffffff;
            --text-dim: #9fb3ff;
            --danger: #ff5d5d;
            --success: #1db954;
        }

        body {
            margin: 0;
            background: radial-gradient(circle at top, var(--bg-header), var(--bg-body));
            color: var(--text-main);
            font-family: 'Segoe UI', sans-serif;
            min-height: 100vh;
        }

        /* Header */
        .header {
            height: 60px;
            background: rgba(5, 11, 30, 0.8);
            backdrop-filter: blur(10px);
            border-bottom: 1px solid rgba(255,255,255,0.1);
            display: flex;
            align-items: center;
            padding: 0 30px;
            position: sticky;
            top: 0;
            z-index: 100;
        }

        .brand { font-weight: bold; display: flex; align-items: center; gap: 10px; }
        .brand span { color: var(--accent); font-size: 20px; }

        /* Main Layout */
        .container { max-width: 900px; margin: 40px auto; padding: 0 20px; }

        /* Search Form */
        .search-form { margin-bottom: 30px; }
        .search-group {
            display: flex;
            background: rgba(10, 20, 50, 0.9);
            border: 1px solid rgba(255,255,255,0.1);
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0,0,0,0.5);
        }
        .search-group input {
            flex: 1;
            padding: 15px 20px;
            background: transparent;
            border: none;
            color: white;
            outline: none;
        }
        .search-group button {
            background: var(--accent);
            border: none;
            padding: 0 25px;
            font-weight: bold;
            cursor: pointer;
            transition: 0.3s;
        }
        .search-group button:hover { opacity: 0.8; }

        /* Action Bar */
        .action-bar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }
        .btn-add {
            background: var(--success);
            color: white;
            text-decoration: none;
            padding: 8px 16px;
            border-radius: 6px;
            font-size: 14px;
        }

        /* Blog Card */
        .card {
            background: rgba(10, 20, 50, 0.7);
            border: 1px solid rgba(255,255,255,0.05);
            border-radius: 12px;
            padding: 25px;
            margin-bottom: 15px;
            transition: 0.3s;
        }
        .card:hover { border-color: var(--accent); transform: translateY(-3px); }
        .card h2 { margin: 0 0 10px; font-size: 18px; color: var(--accent); }
        .card p { font-size: 14px; color: #ccc; line-height: 1.6; }
        .card-meta { font-size: 12px; color: var(--text-dim); margin-bottom: 15px; }

        /* Footer Action */
        .card-links { border-top: 1px solid rgba(255,255,255,0.1); padding-top: 15px; }
        .card-links a { text-decoration: none; font-size: 13px; margin-right: 15px; }
        .link-edit { color: var(--accent); }
        .link-delete { color: var(--danger); }

        /* Alert/Status */
        .search-info {
            background: rgba(93, 169, 255, 0.1);
            border-left: 4px solid var(--accent);
            padding: 12px;
            margin-bottom: 20px;
            font-size: 14px;
        }
    </style>
</head>
<body>

<div class="header">
    <div class="brand"><span>🛡️</span> Wazuh Security Lab | Blog Manager</div>
</div>

<div class="container">
    
    <form class="search-form" method="GET">
        <div class="search-group">
            <input type="text" name="q" placeholder="Search logs, titles, or content..." value="<?php echo $q; ?>">
            <button type="submit">SEARCH</button>
        </div>
    </form>

    <div class="action-bar">
        <h3>Article Management</h3>
        <a href="blog_add.php" class="btn-add">+ New Post</a>
    </div>

    <?php if ($q !== ''): ?>
        <div class="search-info">
            Showing results for: <strong><?php echo $q; ?></strong>
        </div>
    <?php endif; ?>

    <?php if (mysqli_num_rows($result) > 0): ?>
        <?php while($row = mysqli_fetch_assoc($result)): ?>
            <div class="card">
                <h2><?php echo $row['title']; ?></h2>
                <div class="card-meta">
                    📅 <?php echo date('d M Y', strtotime($row['created_at'])); ?> | 👤 Admin
                </div>
                <p>
                    <?php echo substr(strip_tags($row['content']), 0, 150); ?>...
                </p>
                <div class="card-links">
                    <a href="blog_edit.php?id=<?php echo $row['id']; ?>" class="link-edit">✏️ EDIT</a>
                    <a href="blog_delete.php?id=<?php echo $row['id']; ?>" 
                       class="link-delete" 
                       onclick="return confirm('Are you sure you want to delete this?')">🗑️ DELETE</a>
                </div>
            </div>
        <?php endwhile; ?>
    <?php else: ?>
        <div style="text-align: center; padding: 50px; opacity: 0.5;">
            <p>No articles found.</p>
        </div>
    <?php endif; ?>

</div>

</body>
</html>