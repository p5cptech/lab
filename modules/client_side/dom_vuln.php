<?php
session_start();
include '../../config/db.php';
include '../../core/auth.php';
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>DOM XSS Lab | mrahmatt74 Security</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../../public/assets/client_style.css">
</head>
<body>

<div class="container">
    <div class="header">
        <h2><i class="fas fa-code"></i> DOM-Based XSS Lab</h2>
        <a href="../../index.php" class="btn-back"><i class="fas fa-arrow-left"></i> Dashboard</a>
    </div>

    <div class="card">
        <p>Modul ini mensimulasikan fitur kustomisasi dashboard ADR Group via URL Fragment.</p>

        <div id="welcome-message" style="padding:20px; background:#e8f5e9; border-radius:8px; font-size:1.2rem; color:#1b3d31; text-align:center;">
            </div>

        <script>
            /**
             * TITIK KERENTANAN (DOM XSS)
             * Mengambil data dari URL (setelah tanda #) dan memasukkannya 
             * ke dalam innerHTML tanpa filter.
             */
            function loadGreeting() {
                var name = decodeURIComponent(window.location.hash.substring(1));
                if (name) {
                    document.getElementById('welcome-message').innerHTML = "Selamat Datang, " + name + "!";
                } else {
                    document.getElementById('welcome-message').innerHTML = "Silakan tambahkan nama Anda di URL hash (contoh: #Rahmat)";
                }
            }

            window.addEventListener('hashchange', loadGreeting);
            window.onload = loadGreeting;
        </script>

        <div class="payload-hint" style="margin-top:40px;">
            <strong>Lab Objective:</strong><br>
            Eksekusi script tanpa me-refresh halaman (hanya mengubah hash URL):<br>
            1. Payload Image (Bypass filter sederhana):<br>
            <code>#&lt;img src=x onerror=alert('DOM_XSS')&gt;</code><br><br>
            2. Payload Iframe:<br>
            <code>#&lt;iframe src="javascript:alert(1)"&gt;</code>
        </div>
    </div>
</div>

</body>
</html>