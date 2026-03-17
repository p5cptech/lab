<?php
session_start();
include '../../config/db.php';
include '../../core/auth.php';

$content = "";
$filename = isset($_GET['file']) ? $_GET['file'] : "";
$debug_path = "";

if ($filename) {
    /**
     * PENYESUAIAN REAL DIR:
     * File ini ada di: /var/www/mrahmatt74/modules/server_side/
     * Kita akan mencoba membaca file dari folder: /var/www/mrahmatt74/storage/docs/
     */
    $base_dir = "/var/www/mrahmatt74/modules/server_side/"; 
    $path = $base_dir . $filename;

    // Untuk membantu debugging di lab
    $debug_path = $path;

    if (file_exists($path)) {
        $content = file_get_contents($path);
    } else {
        $error = "File tidak ditemukan. Path yang dicoba: <code>" . htmlspecialchars($path) . "</code>";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Path Traversal Lab | mrahmatt74</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../../public/assets/path_traversal.css">
</head>
<body>

<div class="container">
    <div class="header">
        <h2><i class="fas fa-folder-open"></i> Path Traversal Lab</h2>
        <a href="../../index.php" class="btn-back"><i class="fas fa-arrow-left"></i> Dashboard</a>
    </div>

    <div class="card">
        <p>Gunakan modul ini untuk membaca dokumen teknis di server <strong>Wazuh-Server</strong>.</p>
        
        <div class="file-browser">
            <a href="?file=readme.txt" class="file-item"><i class="fas fa-file-alt"></i> readme.txt</a>
            <a href="?file=policy.txt" class="file-item"><i class="fas fa-file-alt"></i> policy.txt</a>
        </div>

        <?php if (isset($error)): ?>
            <div class="error-msg"><?= $error ?></div>
        <?php endif; ?>

        <div class="viewer-container">
            <div class="viewer-header">
                <i class="fas fa-eye"></i> Viewing: <?= htmlspecialchars($filename) ?>
            </div>
            <div class="viewer-content">
                <?php if ($content): ?>
                    <pre><?= htmlspecialchars($content) ?></pre>
                <?php else: ?>
                    <p style="color:#999; text-align:center;">Pilih file atau gunakan payload <code>../</code> pada URL.</p>
                <?php endif; ?>
            </div>
        </div>

        <div style="margin-top: 20px; font-size: 0.8rem; color: #666; font-family: monospace;">
            Query Path: <?= htmlspecialchars($debug_path) ?>
        </div>

        <div class="payload-hint">
            <strong>Lab Objective:</strong><br>
            Berdasarkan <code>ls /etc</code> di server kamu, coba baca file berikut:<br>
            1. <strong>Password File:</strong> <code>?file=../../../../etc/passwd</code><br>
            2. <strong>Network Config:</strong> <code>?file=../../../../etc/networks</code><br>
            3. <strong>Web Config:</strong> <code>?file=../config/db.php</code>
        </div>
    </div>
</div>

</body>
</html>