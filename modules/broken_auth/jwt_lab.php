<?php
/**
 * JWT & Cookie Manipulation Lab
 * Tema: #285A48 (Deep Green)
 */

$message = "Silakan login terlebih dahulu untuk melihat status akses.";
$status_class = "info";
$auth_data = null;

if (isset($_COOKIE['user_auth'])) {
    $decoded_json = base64_decode($_COOKIE['user_auth']);
    $auth_data = json_decode($decoded_json, true);

    if ($auth_data) {
        // Pastikan key 'admin' dan 'role' ada untuk mencegah Undefined Array Key
        $role = $auth_data['role'] ?? 'guest';
        $isAdmin = $auth_data['admin'] ?? false;

        if ($isAdmin === true) {
            $message = "AKSES ADMINISTRATOR DITERIMA! <br> Flag: <code>ADR{JSON_Cook1e_Privilege_Escalation}</code>";
            $status_class = "success";
        } else {
            $message = "Halo " . htmlspecialchars($auth_data['user'] ?? 'Unknown') . ", Anda masuk sebagai <b>" . htmlspecialchars($role) . "</b>.";
            $status_class = "warning";
        }
    } else {
        $message = "Format Cookie tidak valid.";
        $status_class = "danger";
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Broken Auth Lab | mrahmatt74</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        :root { 
            --primary: #285A48; 
            --accent: #3d846a;
            --bg: #f4f7f6;
            --danger: #e74c3c;
        }
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background: var(--bg); margin: 0; padding: 20px; }
        .container { max-width: 800px; margin: auto; }
        .header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; color: var(--primary); }
        .card { background: white; padding: 30px; border-radius: 15px; box-shadow: 0 10px 25px rgba(0,0,0,0.1); border-top: 8px solid var(--primary); }
        .status-box { padding: 20px; border-radius: 8px; margin-bottom: 20px; font-weight: 500; text-align: center; font-size: 1.1rem; }
        .info { background: #e3f2fd; color: #0d47a1; border: 1px solid #2196f3; }
        .warning { background: #fff3cd; color: #856404; border: 1px solid #ffca28; }
        .success { background: #d4edda; color: #155724; border: 1px solid #28a745; }
        .danger { background: #f8d7da; color: #721c24; border: 1px solid var(--danger); }
        .debug-header { font-weight: bold; margin-bottom: 10px; color: var(--primary); display: block; }
        .debug-box { background: #2d2d2d; color: #f8f8f2; padding: 15px; border-radius: 8px; font-family: 'Consolas', monospace; font-size: 0.9rem; word-break: break-all; }
        .json-key { color: #ff79c6; }
        .json-val { color: #f1fa8c; }
        .json-bool { color: #bd93f9; font-weight: bold; }
        .hint-section { margin-top: 25px; padding: 15px; background: #f9f9f9; border-left: 5px solid var(--primary); border-radius: 4px; }
        .btn-back { text-decoration: none; color: white; background: var(--primary); padding: 8px 15px; border-radius: 5px; transition: 0.3s; }
        .btn-back:hover { background: var(--accent); }
        code { background: #333; color: #fff; padding: 2px 6px; border-radius: 4px; }
    </style>
</head>
<body>

<div class="container">
    <div class="header">
        <h2><i class="fas fa-fingerprint"></i> Authentication Analysis</h2>
        <a href="index.php" class="btn-back"><i class="fas fa-arrow-left"></i> Dashboard</a>
    </div>

    <div class="card">
        <div class="status-box <?php echo $status_class; ?>">
            <?php echo $message; ?>
        </div>

        <?php if ($auth_data): ?>
        <span class="debug-header">Data JSON yang terbaca dari Cookie:</span>
        <div class="debug-box">
            {<br>
            &nbsp;&nbsp;<span class="json-key">"user"</span>: <span class="json-val">"<?php echo htmlspecialchars($auth_data['user'] ?? 'N/A'); ?>"</span>,<br>
            &nbsp;&nbsp;<span class="json-key">"role"</span>: <span class="json-val">"<?php echo htmlspecialchars($auth_data['role'] ?? 'N/A'); ?>"</span>,<br>
            &nbsp;&nbsp;<span class="json-key">"admin"</span>: <span class="json-bool"><?php echo ($auth_data['admin'] ?? false) ? 'true' : 'false'; ?></span>,<br>
            &nbsp;&nbsp;<span class="json-key">"iat"</span>: <span class="json-val"><?php echo htmlspecialchars($auth_data['iat'] ?? time()); ?></span><br>
            }
        </div>
        <?php endif; ?>

        <div class="hint-section">
            <strong>Lab Objective:</strong><br>
            Aplikasi ini mempercayai status administrator berdasarkan flag <code>"admin": true</code> di dalam data JSON yang di-encode ke Base64 pada cookie <code>user_auth</code>.
            <br><br>
            <strong>Misi:</strong> 
            Gunakan <i>Cookie Editor</i> atau <i>CyberChef</i> untuk mengubah nilai <code>admin</code> menjadi <code>true</code> dan akses hak istimewa administrator.
        </div>
    </div>
</div>

</body>
</html>