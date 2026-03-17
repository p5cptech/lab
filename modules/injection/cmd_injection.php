<?php
session_start();
include '../../config/db.php';
include '../../core/auth.php';

// check_auth(); // Opsional: Aktifkan jika ingin membatasi akses

$output = "";
$target = "";

if (isset($_POST['target'])) {
    $target = $_POST['target'];

    /**
     * TITIK KERENTANAN (OS COMMAND INJECTION)
     * Input $target langsung digabung ke perintah shell tanpa sanitasi (escapeshellarg).
     */
    if (stristr(PHP_OS, 'WIN')) {
        // Jika berjalan di Windows
        $cmd = "ping " . $target;
    } else {
        // Jika berjalan di Linux (seperti server Wazuh kamu)
        $cmd = "ping -c 3 " . $target;
    }

    // Mengeksekusi perintah di sistem operasi
    $output = shell_exec($cmd);
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Command Injection Lab | mrahmatt74</title>
    <link rel="stylesheet" href="../../public/assets/cmd_injection.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body>

<div class="container">
    <div class="header">
        <h2><i class="fas fa-terminal"></i> Command Injection Lab</h2>
        <a href="../../index.php" class="btn-back"><i class="fas fa-arrow-left"></i> Dashboard</a>
    </div>

    <div class="card">
        <p>Gunakan alat ini untuk mengecek konektivitas jaringan ke host tertentu (Ping Tool).</p>
        
        <form method="POST" class="input-group">
            <input type="text" name="target" placeholder="Contoh: 8.8.8.8 atau google.com" value="<?= htmlspecialchars($target) ?>" required>
            <button type="submit">Run Diagnostic</button>
        </form>

        <div class="terminal">
            <?php 
            if ($output) {
                echo htmlspecialchars($output); 
            } else if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                echo "Command executed, but no output returned.";
            } else {
                echo "Waiting for command...";
            }
            ?>
        </div>

        <div class="payload-hint">
            <strong>Lab Objective:</strong><br>
            Coba manipulasi input untuk mengeksekusi perintah tambahan di server:<br>
            1. <code>8.8.8.8 ; whoami</code> (Linux) atau <code>8.8.8.8 & whoami</code> (Windows)<br>
            2. <code>8.8.8.8 ; ls -la /etc/passwd</code> (Membaca file sensitif)<br>
            3. <code>8.8.8.8 ; cat /var/www/mrahmatt74/config/db.php</code> (Mencuri kredensial database)
        </div>
    </div>
</div>

</body>
</html>