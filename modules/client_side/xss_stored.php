<?php
session_start();
include '../../config/db.php';
include '../../core/auth.php';

// Proses Simpan Komentar
if (isset($_POST['submit_comment'])) {
    $user = $_SESSION['username'] ?? 'Guest';
    $comment = $_POST['comment']; // TITIK KERENTANAN: Tidak ada sanitasi

    $query = "INSERT INTO xss_comments (username, comment) VALUES ('$user', '$comment')";
    mysqli_query($conn, $query);
}

// Ambil Semua Komentar
$comments = mysqli_query($conn, "SELECT * FROM xss_comments ORDER BY created_at DESC");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Stored XSS Lab | mrahmatt74 Security</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../../public/assets/xss.css">
</head>
<body>

<div class="container">
    <div class="header">
        <h2><i class="fas fa-database"></i> Stored XSS Lab</h2>
        <a href="../../index.php" class="btn-back"><i class="fas fa-arrow-left"></i> Dashboard</a>
    </div>

    <div class="card">
        <p>Simulasi forum internal ADR Group. Komentar yang Anda tulis akan tersimpan secara permanen.</p>

        <form method="POST" style="margin-bottom: 30px;">
            <textarea name="comment" placeholder="Tulis komentar Anda..." required 
                      style="width:100%; height:100px; padding:12px; border:2px solid #eee; border-radius:8px; margin-bottom:10px;"></textarea>
            <button type="submit" name="submit_comment" style="background:#285A48; color:white; border:none; padding:10px 20px; border-radius:8px; cursor:pointer;">
                Kirim Komentar
            </button>
        </form>

        <div class="comment-list">
            <h3>Komentar Terbaru:</h3>
            <hr style="margin:15px 0; border:0; border-top:1px solid #eee;">
            <?php while($row = mysqli_fetch_assoc($comments)): ?>
                <div style="background:#f9f9f9; padding:15px; border-radius:8px; margin-bottom:15px; border-left:5px solid #285A48;">
                    <strong><?= $row['username'] ?>:</strong> 
                    <span><?= $row['comment'] ?></span> <br><small style="color:#999;"><?= $row['created_at'] ?></small>
                </div>
            <?php endwhile; ?>
        </div>

        <div class="payload-hint">
            <strong>Lab Objective:</strong><br>
            Coba masukkan script yang mencuri cookie setiap kali halaman di-refresh:<br>
            <code>&lt;script&gt;document.write('Cookie Anda: ' + document.cookie);&lt;/script&gt;</code>
        </div>
    </div>
</div>
</body>
</html>