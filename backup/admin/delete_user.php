<?php
/**
 * LAB PENTEST: VULNERABLE DELETE PAGE
 * Target: SQL Injection, IDOR, CSRF
 */
require '../config/db.php';
session_start();

$id = $_GET['id'] ?? null;
$user_to_delete = null;

// ❌ VULNERABLE 1: SQL Injection (GET)
if ($id) {
    $sql_check = "SELECT * FROM users WHERE id = $id";
    $result = mysqli_query($conn, $sql_check);
    $user_to_delete = mysqli_fetch_assoc($result);
}

// Proses Penghapusan
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['confirm_delete'])) {
    $target_id = $_POST['target_id'];
    
    // ❌ VULNERABLE 2: SQL Injection (POST) & IDOR
    $sql_delete = "DELETE FROM users WHERE id = $target_id";
    
    if (mysqli_query($conn, $sql_delete)) {
        // Berhasil -> Langsung ke users.php sesuai permintaan
        header("Location: users.php?status=deleted");
        exit();
    } else {
        $error_db = mysqli_error($conn); // ❌ Information Leakage
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Hapus User | Lab Pentest</title>
    <style>
        * { box-sizing: border-box; font-family: 'Segoe UI', sans-serif; }
        body {
            margin: 0; min-height: 100vh;
            background: radial-gradient(circle at top, #1a0a0a, #050505);
            display: flex; align-items: center; justify-content: center; color: #fff;
        }
        .delete-card {
            width: 90%; max-width: 400px; background: rgba(30, 10, 10, 0.9);
            border: 1px solid rgba(255, 77, 77, 0.3); border-radius: 24px;
            padding: 40px; text-align: center; backdrop-filter: blur(15px);
            box-shadow: 0 25px 50px rgba(0,0,0,0.8);
        }
        .icon { font-size: 50px; color: #ff4d4d; margin-bottom: 15px; }
        h2 { margin: 0; color: #ff4d4d; font-size: 22px; }
        p { color: #8a9fcb; font-size: 14px; margin-bottom: 25px; }
        .user-box {
            background: rgba(255,255,255,0.05); padding: 15px; border-radius: 15px;
            margin-bottom: 25px; border: 1px solid rgba(255,255,255,0.1);
        }
        .user-box b { display: block; font-size: 18px; color: #fff; }
        .btn-group { display: flex; gap: 10px; }
        .btn {
            flex: 1; padding: 12px; border-radius: 12px; font-weight: 600;
            cursor: pointer; text-decoration: none; border: none; transition: 0.2s;
        }
        .btn-confirm { background: #ff4d4d; color: #fff; }
        .btn-confirm:hover { background: #ff2a2a; transform: scale(1.02); }
        .btn-cancel { background: #333; color: #ccc; }
        .btn-cancel:hover { background: #444; color: #fff; }
        .error-msg { margin-top: 15px; font-size: 11px; color: #ff8080; font-family: monospace; }
    </style>
</head>
<body>

<div class="delete-card">
    <div class="icon">🗑️</div>
    <h2>Konfirmasi Hapus</h2>
    
    <?php if ($user_to_delete): ?>
        <p>Anda yakin ingin menghapus user ini? Akun tidak dapat dipulihkan.</p>
        <div class="user-box">
            <b><?= $user_to_delete['full_name'] ?></b>
            <small>@<?= $user_to_delete['username'] ?></small>
        </div>

        <form method="POST">
            <input type="hidden" name="target_id" value="<?= $user_to_delete['id'] ?>">
            <div class="btn-group">
                <a href="users.php" class="btn btn-cancel">Batal</a>
                <button type="submit" name="confirm_delete" class="btn btn-confirm">Hapus Akun</button>
            </div>
        </form>
    <?php else: ?>
        <p>User tidak ditemukan.</p>
        <a href="users.php" class="btn btn-cancel">Kembali</a>
    <?php endif; ?>

    <?php if (isset($error_db)): ?>
        <div class="error-msg">SQL Error: <?= $error_db ?></div>
    <?php endif; ?>
</div>

</body>
</html>