<?php
session_start();
include '../../config/db.php';
include '../../core/auth.php';

$output = "";
$name = "";

if (isset($_GET['name'])) {
    $name = $_GET['name'];

    /**
     * TITIK KERENTANAN (SSTI)
     * Input user ($name) langsung diolah oleh fungsi yang mengevaluasi string
     * seolah-olah itu adalah bagian dari kode template/logika server.
     */
    
    // Simulasi template engine sederhana yang mendukung ekspresi matematika
    // Vulnerable: eval() atau pemrosesan regex yang tidak aman pada input user
    $template = "Halo, selamat datang kembali " . $name . "!";
    
    // Logika rentan: mencari pola {{ ... }} dan mengeksekusinya
    $output = preg_replace_callback('/\{\{(.*)\}\}/', function($matches) {
        try {
            // Mengevaluasi kode di dalam kurung kurawal
            return eval("return " . $matches[1] . ";");
        } catch (Throwable $e) {
            return "[Error in expression]";
        }
    }, $template);
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SSTI Lab | mrahmatt74 Security</title>
    <link rel="stylesheet" href="../../public/assets/ssti.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body>

<div class="container">
    <div class="header">
        <h2><i class="fas fa-code"></i> SSTI Lab</h2>
        <a href="../../index.php" class="btn-back"><i class="fas fa-arrow-left"></i> Dashboard</a>
    </div>

    <div class="card">
        <p>Masukkan nama Anda untuk di-render oleh template engine lab:</p>
        
        <form method="GET" class="search-box">
            <input type="text" name="name" placeholder="Contoh: Rahmat" value="<?= htmlspecialchars($name) ?>">
            <button type="submit">Render Template</button>
        </form>

        <div class="render-box">
            <div class="render-output">
                <?php 
                if ($output) {
                    echo $output; // Sengaja tidak di-escape agar XSS juga memungkinkan
                } else {
                    echo "<em>Silakan masukkan input untuk melihat hasil render.</em>";
                }
                ?>
            </div>
        </div>

        <div class="payload-hint">
            <strong>Lab Objective:</strong><br>
            Template ini mendukung ekspresi matematika dan kode PHP di dalam kurung kurawal <code>{{ ... }}</code>.<br>
            1. Coba kalkulasi sederhana: <code>{{ 7 * 7 }}</code><br>
            2. Identifikasi sistem: <code>{{ phpversion() }}</code><br>
            3. Remote Code Execution (RCE): <code>{{ system('id') }}</code> atau <code>{{ system('ls -la') }}</code>
        </div>
    </div>
</div>

</body>
</html>