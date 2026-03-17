<?php
/**
 * Web Cache Poisoning Lab
 * Tema: #285A48 (Deep Green)
 * Kerentanan: Unkeyed Input (X-Forwarded-Host)
 */

// Simulasi Cache Logic (Sederhana)
$cache_file = 'cache_page.html';
$cache_time = 30; // Cache berlaku selama 30 detik

// Ambil Host dari header (ini adalah bagian yang berbahaya jika tidak di-key)
$host = $_SERVER['HTTP_HOST'];
if (isset($_SERVER['HTTP_X_FORWARDED_HOST'])) {
    $host = $_SERVER['HTTP_X_FORWARDED_HOST'];
}

// Cek apakah cache masih valid
if (file_exists($cache_file) && (time() - filemtime($cache_file) < $cache_time)) {
    $is_cached = true;
    $content = file_get_contents($cache_file);
} else {
    $is_cached = false;
    // Membangun konten halaman dengan menyisipkan Host yang bisa dimanipulasi
    ob_start();
    ?>
    <div class="status-box info">
        <i class="fas fa-server"></i> Halaman ini baru saja di-generate dari server origin.
    </div>
    <p>Gunakan script ini untuk integrasi tracking:</p>
    <script src="http://<?php echo htmlspecialchars($host); ?>/tracking.js"></script>
    <div class="debug-box">
        Source URL: http://<?php echo htmlspecialchars($host); ?>/modules/advanced/cache_poison.php
    </div>
    <?php
    $content = ob_get_clean();
    file_put_contents($cache_file, $content);
}

?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Web Cache Poisoning Lab | mrahmatt74</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        :root { --primary: #285A48; --accent: #3d846a; --bg: #f0f2f1; }
        body { font-family: 'Segoe UI', sans-serif; background: var(--bg); margin: 0; padding: 20px; }
        .container { max-width: 850px; margin: auto; }
        .header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; color: var(--primary); }
        .card { background: white; padding: 30px; border-radius: 15px; box-shadow: 0 10px 25px rgba(0,0,0,0.1); border-top: 8px solid var(--primary); }
        .status-box { padding: 15px; border-radius: 8px; margin-bottom: 20px; font-weight: 500; }
        .info { background: #e3f2fd; color: #0d47a1; border-left: 5px solid #2196f3; }
        .cached { background: #fff3cd; color: #856404; border-left: 5px solid #ffca28; }
        .debug-box { background: #2d2d2d; color: #a9ffad; padding: 15px; border-radius: 8px; font-family: monospace; margin-top: 15px; }
        .hint { margin-top: 25px; padding: 15px; background: #f9f9f9; border: 1px dashed var(--primary); border-radius: 8px; }
        .btn-back { text-decoration: none; color: white; background: var(--primary); padding: 8px 15px; border-radius: 5px; }
    </style>
</head>
<body>

<div class="container">
    <div class="header">
        <h2><i class="fas fa-vial"></i> Web Cache Poisoning Lab</h2>
        <a href="../index.php" class="btn-back">Kembali</a>
    </div>

    <div class="card">
        <?php if ($is_cached): ?>
            <div class="status-box cached">
                <i class="fas fa-clock"></i> <strong>DATA DARI CACHE:</strong> Konten ini diambil dari cache server.
            </div>
        <?php endif; ?>

        <?php echo $content; ?>

        <div class="hint">
            <strong>Misi Lab:</strong><br>
            Aplikasi ini menggunakan header <code>X-Forwarded-Host</code> untuk menentukan lokasi script tracking. 
            <br><br>
            <strong>Langkah Eksploitasi:</strong>
            <ol>
                <li>Gunakan <code>curl</code> atau Burp Suite untuk mengirim request dengan header: <br><code>X-Forwarded-Host: attacker.com</code></li>
                <li>Jika beruntung (saat cache sedang kosong), server akan menyimpan domain penyerang ke dalam cache.</li>
                <li>Semua user lain yang mengakses halaman ini dalam 30 detik ke depan akan memuat script dari <code>attacker.com</code>.</li>
            </ol>
        </div>
    </div>
</div>

</body>
</html>