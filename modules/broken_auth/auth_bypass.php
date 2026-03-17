<?php
session_start();

// --- LOGIKA KERENTANAN (VULNERABILITY LOGIC) ---
// Kerentanan: Server mempercayai input user dari parameter URL atau Cookie 
// untuk menentukan status hak akses tanpa validasi database/session yang ketat.
$isAdmin = false;

if (isset($_GET['admin']) && $_GET['admin'] === 'true') {
    $isAdmin = true;
    $_SESSION['role'] = 'admin';
}

// Simulasi Data Sensitif
$secretData = [
    "vault_key" => "ADR-VAULT-2026-X99",
    "db_password" => "P@ssw0rd123!",
    "backup_server" => "10.10.50.22"
];

?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Auth Bypass Lab | mrahmatt74</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        :root {
            --primary-color: #285A48;
            --bg-color: #f0f2f1;
            --danger: #e74c3c;
        }
        body { font-family: 'Segoe UI', sans-serif; background: var(--bg-color); margin: 0; padding: 20px; }
        .container { max-width: 800px; margin: auto; }
        .header { background: var(--primary-color); color: white; padding: 20px; border-radius: 10px 10px 0 0; display: flex; justify-content: space-between; align-items: center; }
        .card { background: white; padding: 25px; border-radius: 0 0 10px 10px; box-shadow: 0 4px 10px rgba(0,0,0,0.1); }
        .status-box { padding: 15px; border-radius: 8px; margin-bottom: 20px; font-weight: bold; text-align: center; }
        .status-denied { background: #ffdada; color: #a94442; border: 1px solid #ebccd1; }
        .status-granted { background: #dff0d8; color: #3c763d; border: 1px solid #d6e9c6; }
        .secret-content { background: #2d2d2d; color: #85e89d; padding: 20px; border-radius: 8px; font-family: 'Consolas', monospace; }
        .hint { margin-top: 20px; font-size: 0.9rem; color: #666; border-left: 4px solid var(--primary-color); padding-left: 15px; }
        code { background: #eee; padding: 2px 5px; border-radius: 4px; color: var(--danger); }
        .btn-reset { display: inline-block; margin-top: 10px; text-decoration: none; color: var(--primary-color); font-size: 0.8rem; }
    </style>
</head>
<body>

<div class="container">
    <div class="header">
        <h2><i class="fas fa-user-shield"></i> Broken Auth Lab</h2>
        <span>mrahmatt74</span>
    </div>

    <div class="card">
        <?php if (!$isAdmin): ?>
            <div class="status-box status-denied">
                <i class="fas fa-lock"></i> AKSES DITOLAK: Anda masuk sebagai Guest.
            </div>
            <p>Halaman ini berisi informasi rahasia yang hanya bisa diakses oleh <strong>Administrator</strong>.</p>
            
            <div class="hint">
                <strong>Lab Objective:</strong><br>
                Analisis bagaimana aplikasi menentukan status admin. Coba manipulasi parameter permintaan untuk melewati (bypass) autentikasi.
            </div>
        <?php else: ?>
            <div class="status-box status-granted">
                <i class="fas fa-unlock-alt"></i> AKSES DITERIMA: Selamat Datang, Administrator!
            </div>
            
            <h3><i class="fas fa-database"></i> Internal Sensitive Data:</h3>
            <div class="secret-content">
                <pre><?php print_r($secretData); ?></pre>
            </div>
            <a href="auth_bypass.php" class="btn-reset">Logout / Reset Lab</a>
        <?php endif; ?>
    </div>
</div>

</body>
</html>