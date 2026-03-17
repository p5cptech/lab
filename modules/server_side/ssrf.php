<?php
session_start();
include '../../config/db.php';
include '../../core/auth.php';

$response = "";
$url = isset($_POST['url']) ? $_POST['url'] : "";


if ($url) {
    /**
     * TITIK KERENTANAN (SSRF)
     * Aplikasi menerima URL dari user dan langsung melakukan request
     * dari sisi server tanpa memvalidasi apakah itu IP internal atau localhost.
     */
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HEADER, false);
    curl_setopt($ch, CURLOPT_TIMEOUT, 5);

    $response = curl_exec($ch);
    
    if(curl_errno($ch)) {
        $error = "cURL Error: " . curl_error($ch);
    }
    curl_close($ch);
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SSRF Lab | mrahmatt74 Security</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../../public/assets/ssrf.css">
    <link rel="stylesheet" href="style.css">
    
</head>
<body>

<div class="container">
    <div class="header">
        <h2><i class="fas fa-network-wired"></i> SSRF Lab</h2>
        <a href="../../index.php" class="btn-back"><i class="fas fa-arrow-left"></i> Dashboard</a>
    </div>

    <div class="card">
        <p>Gunakan layanan <strong>ADR Internal Proxy</strong> untuk mengambil data dari URL eksternal.</p>
        
        <form method="POST" class="input-group">
            <input type="text" name="url" placeholder="Contoh: http://google.com" value="<?= htmlspecialchars($url) ?>" required>
            <button type="submit">Fetch Data</button>
        </form>

        <?php if (isset($error)): ?>
            <div class="error-msg"><?= $error ?></div>
        <?php endif; ?>

        <div class="preview-container">
            <div class="preview-header">
                <i class="fas fa-file-code"></i> Response Preview
            </div>
            <div class="preview-content">
                <?php if ($response): ?>
                    <pre><?= htmlspecialchars($response) ?></pre>
                <?php else: ?>
                    <p style="color:#999; text-align:center;">Masukkan URL untuk melihat respon dari server.</p>
                <?php endif; ?>
            </div>
        </div>

        <div class="payload-hint">
            <strong>Lab Objective:</strong><br>
            Server ini memiliki layanan internal yang hanya bisa diakses via localhost:<br>
            1. Scan Port Lokal: <code>http://127.0.0.1:80</code> atau <code>http://127.0.0.1:22</code><br>
            2. Cek Wazuh Indexer: <code>http://127.0.0.1:9200</code><br>
            3. Membaca File Lokal (via file protocol): <code>file:///etc/passwd</code>
        </div>
    </div>
</div>

</body>
</html>