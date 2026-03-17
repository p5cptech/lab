<?php
session_start();
include '../../config/db.php';
include '../../core/auth.php';

// Proteksi opsional: Hanya admin yang bisa akses lab ini (Bisa dimatikan untuk testing)
// check_auth(); 

$user_data = null;
$search_query = "";

if (isset($_GET['id'])) {
    $search_query = $_GET['id'];

    // --- TITIK KERENTANAN (SQL INJECTION) ---
    // Input $_GET['id'] langsung digabung ke string query tanpa filter/prepared statement
    $sql = "SELECT username, email, role, bio FROM users WHERE id = " . $search_query;
    
    // Menggunakan mysqli_query yang akan mengeksekusi payload SQLi
    $result = mysqli_query($conn, $sql);

    if ($result) {
        $user_data = mysqli_fetch_assoc($result);
    } else {
        // ERROR DISCLOSURE: Membantu attacker melakukan error-based SQLi
        $db_error = mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SQL Injection Lab | mrahmatt74</title>
    <link rel="stylesheet" href="../../public/assets/sqli.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        :root {
            --primary: #285A48;
            --bg: #f4f7f6;
        }
        body { font-family: 'Segoe UI', sans-serif; background: var(--bg); margin: 0; padding: 20px; }
        .container { max-width: 800px; margin: 0 auto; }
        .card { background: white; padding: 25px; border-radius: 12px; box-shadow: 0 4px 15px rgba(0,0,0,0.1); border-top: 5px solid var(--primary); }
        .header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; }
        .btn-back { text-decoration: none; color: var(--primary); font-weight: 600; font-size: 0.9rem; }
        
        .search-box { display: flex; gap: 10px; margin-bottom: 20px; }
        input { flex: 1; padding: 12px; border: 1px solid #ddd; border-radius: 8px; }
        button { background: var(--primary); color: white; border: none; padding: 10px 20px; border-radius: 8px; cursor: pointer; }
        
        .result-box { background: #fafafa; border: 1px solid #eee; padding: 20px; border-radius: 8px; }
        .error-box { background: #fff5f5; border: 1px solid #feb2b2; color: #c53030; padding: 15px; border-radius: 8px; margin-top: 10px; font-family: monospace; }
        
        .payload-hint { margin-top: 30px; font-size: 0.85rem; color: #666; }
        code { background: #e2e8f0; padding: 2px 5px; border-radius: 4px; color: #2d3748; }
    </style>
</head>
<body>

<div class="container">
    <div class="header">
        <h2><i class="fas fa-database"></i> SQL Injection Lab</h2>
        <a href="../../index.php" class="btn-back"><i class="fas fa-arrow-left"></i> Kembali</a>
    </div>

    <div class="card">
        <p>Cari informasi user berdasarkan <strong>User ID</strong>:</p>
        <form method="GET" class="search-box">
            <input type="text" name="id" placeholder="Masukkan ID (contoh: 1)" value="<?= htmlspecialchars($search_query) ?>">
            <button type="submit"><i class="fas fa-search"></i> Cari</button>
        </form>

        <?php if (isset($db_error)): ?>
            <div class="error-box">
                <strong>SQL Error:</strong><br>
                <?= $db_error ?>
            </div>
        <?php endif; ?>

        <div class="result-box">
            <?php if ($user_data): ?>
                <table style="width:100%; border-collapse: collapse;">
                    <tr><td style="width:100px; font-weight:bold;">Username</td><td>: <?= $user_data['username'] ?></td></tr>
                    <tr><td style="font-weight:bold;">Email</td><td>: <?= $user_data['email'] ?></td></tr>
                    <tr><td style="font-weight:bold;">Role</td><td>: <?= $user_data['role'] ?></td></tr>
                    <tr><td style="font-weight:bold;">Bio</td><td>: <?= $user_data['bio'] ?></td></tr>
                </table>
            <?php elseif (isset($_GET['id'])): ?>
                <p style="color: #888; text-align: center;">User tidak ditemukan.</p>
            <?php else: ?>
                <p style="color: #888; text-align: center;">Masukkan ID untuk memulai pencarian.</p>
            <?php endif; ?>
        </div>

        <div class="payload-hint">
            <strong>Lab Objective:</strong><br>
            1. Gunakan payload <code>1' OR '1'='1</code> untuk menampilkan user pertama.<br>
            2. Gunakan <code>1 UNION SELECT 1,2,3,4-- -</code> untuk mencari jumlah kolom.<br>
            3. Gunakan <code>1 AND (SELECT 1 FROM (SELECT COUNT(*),CONCAT(0x7e,database(),0x7e)x FROM information_schema.tables GROUP BY x)a)</code> untuk Error-Based.
        </div>
    </div>
</div>

</body>
</html>