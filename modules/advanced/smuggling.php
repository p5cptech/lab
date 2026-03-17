<?php
/**
 * HTTP Request Smuggling Lab
 * Tema: #285A48 (Deep Green)
 * Deskripsi: Simulasi ketidaksesuaian parsing CL.TE atau TE.CL
 */

// Simulasi Header yang diterima dari Front-end (Proxy)
$headers = getallheaders();
$is_admin = false;

// LOGIKA VULNERABLE: 
// Dalam skenario smuggling, penyerang menyelundupkan request kedua 
// yang seolah-olah berasal dari internal/admin.
if (isset($headers['X-Internal-Secret']) && $headers['X-Internal-Secret'] === 'secret_key_123') {
    $is_admin = true;
}

?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>HTTP Smuggling Lab | mrahmatt74</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        :root { --primary: #285A48; --accent: #3d846a; --bg: #f0f2f1; }
        body { font-family: 'Segoe UI', sans-serif; background: var(--bg); margin: 0; padding: 20px; }
        .container { max-width: 850px; margin: auto; }
        .card { background: white; padding: 30px; border-radius: 15px; box-shadow: 0 10px 25px rgba(0,0,0,0.1); border-top: 8px solid var(--primary); }
        .header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; color: var(--primary); }
        .status-box { padding: 20px; border-radius: 8px; margin-bottom: 20px; text-align: center; }
        .denied { background: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; }
        .granted { background: #d4edda; color: #155724; border: 1px solid #c3e6cb; }
        .debug-box { background: #2d2d2d; color: #a9ffad; padding: 15px; border-radius: 8px; font-family: monospace; margin-top: 15px; overflow-x: auto; }
        .hint { margin-top: 25px; padding: 15px; background: #e3f2fd; border-left: 5px solid #2196f3; color: #0d47a1; }
        code { background: #333; color: #fff; padding: 2px 5px; border-radius: 3px; }
        .btn-back { text-decoration: none; color: white; background: var(--primary); padding: 8px 15px; border-radius: 5px; }
    </style>
</head>
<body>

<div class="container">
    <div class="header">
        <h2><i class="fas fa-random"></i> HTTP Request Smuggling</h2>
        <a href="../index.php" class="btn-back">Kembali</a>
    </div>

    <div class="card">
        <?php if ($is_admin): ?>
            <div class="status-box granted">
                <i class="fas fa-unlock-alt fa-2x"></i><br>
                <h3>ADMIN ACCESS GRANTED</h3>
                <p>Flag: <code>ADR{HTTP_RS_BYPASS_SUCCESS_74}</code></p>
            </div>
        <?php else: ?>
            <div class="status-box denied">
                <i class="fas fa-lock fa-2x"></i><br>
                <h3>ACCESS DENIED</h3>
                <p>Hanya koneksi internal dengan header rahasia yang diizinkan mengakses area ini.</p>
            </div>
        <?php endif; ?>

        <h4>HTTP Request Headers Terdeteksi:</h4>
        <div class="debug-box">
            <?php
            foreach ($headers as $name => $value) {
                echo "<strong>$name:</strong> $value<br>";
            }
            ?>
        </div>

        <div class="hint">
            <strong>Target Lab:</strong><br>
            Aplikasi ini berada di belakang Reverse Proxy. Gunakan teknik <strong>CL.TE</strong> atau <strong>TE.CL</strong> untuk menyelundupkan request tambahan yang berisi header <code>X-Internal-Secret: secret_key_123</code>.
            <br><br>
            <strong>Payload Contoh (CL.TE):</strong><br>
            <pre style="font-size: 0.8rem; background: #eee; padding: 10px;">
POST /modules/advanced/smuggling.php HTTP/1.1
Host: mrahmatt74.com
Content-Length: 139
Transfer-Encoding: chunked

0

POST /modules/advanced/smuggling.php HTTP/1.1
X-Internal-Secret: secret_key_123
Content-Length: 10

x=</pre>
        </div>
    </div>
</div>

</body>
</html>