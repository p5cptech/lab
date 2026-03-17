<?php 
require('../config/db.php'); 

// PINDAHKAN LOGIKA PHP KE PALING ATAS
// Agar tidak terkena error "headers already sent"
$error_msg = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user = $_POST['username'];
    $pass = $_POST['password'];

    // TETAP VULN SQL INJECTION (Untuk Lab)
    $sql = "SELECT * FROM users WHERE username = '$user' AND password = '$pass'";
    $result = mysqli_query($conn, $sql);

    if ($row = mysqli_fetch_assoc($result)) {
        // Ambil role, jika kolom 'role' tidak ada, pakai default 'guest' agar tidak error Undefined
        $role = isset($row['role']) ? $row['role'] : 'guest';
        $username = isset($row['username']) ? $row['username'] : 'unknown';

        // Set Cookie (Tetap vuln tanpa HttpOnly agar bisa di-XSS)
        setcookie("session_id", "ADMIN-" . bin2hex(random_bytes(8)), time() + 3600, "/");
        setcookie("user_role", $role, time() + 3600, "/");
        setcookie("auth_token", base64_encode($username), time() + 3600, "/");

        // Redirect ke dashboard admin
        header("Location: ../admin/index.php");
        exit;
    } else {
        $error_msg = "[CRITICAL] AUTH_FAILED: Akses Ditolak";
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LOGIN_GATEWAY | Wazuh Security Lab</title>
    <style>
        /* CSS RETRO TETAP SAMA SEPERTI SEBELUMNYA */
        :root { --bg-color: #121212; --amber: #ffb000; --amber-dim: #946b00; }
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Courier New', Courier, monospace; }
        body {
            background-color: var(--bg-color); color: var(--amber); height: 100vh;
            display: flex; align-items: center; justify-content: center;
            background-image: linear-gradient(rgba(18, 16, 16, 0) 50%, rgba(0, 0, 0, 0.1) 50%);
            background-size: 100% 4px;
        }
        .login-box { width: 100%; max-width: 400px; border: 1px solid var(--amber); background: #000; padding: 2px; }
        .window-header { background: var(--amber); color: #000; padding: 4px 10px; font-weight: bold; font-size: 0.8rem; display: flex; justify-content: space-between; }
        .content { padding: 30px; }
        h1 { font-size: 1.5rem; text-align: center; margin-bottom: 5px; text-transform: uppercase; }
        .subtitle { text-align: center; font-size: 0.8rem; color: var(--amber-dim); margin-bottom: 25px; border-bottom: 1px dashed var(--amber-dim); padding-bottom: 10px; }
        .input-group { margin-bottom: 15px; }
        label { display: block; font-size: 0.8rem; margin-bottom: 5px; }
        input { width: 100%; background: #1a1a1a; border: 1px solid var(--amber-dim); padding: 10px; color: var(--amber); outline: none; }
        input:focus { border-color: var(--amber); }
        button { width: 100%; padding: 12px; background: #000; color: var(--amber); border: 1px solid var(--amber); font-weight: bold; cursor: pointer; margin-top: 10px; }
        button:hover { background: var(--amber); color: #000; }
        .error { margin-top: 20px; padding: 10px; border: 1px solid #ff0000; color: #ff0000; font-size: 0.8rem; text-align: center; }
        .blink { animation: blinker 1s linear infinite; }
        @keyframes blinker { 50% { opacity: 0; } }
    </style>
</head>
<body>

<div class="login-box">
    <div class="window-header">
        <span>SECURE_AUTH.SYS</span>
        <span>[X]</span>
    </div>
    
    <div class="content">
        <h1>WAZUH_LAB</h1>
        <p class="subtitle">SYSTEM STATUS: <span class="blink">PENDING_AUTH...</span></p>

        <form method="POST">
            <div class="input-group">
                <label>USER_ID:</label>
                <input type="text" name="username" placeholder="admin / user" autocomplete="off" required>
            </div>

            <div class="input-group">
                <label>PASS_KEY:</label>
                <input type="password" name="password" placeholder="********" required>
            </div>

            <button type="submit">ACCESS_GRANT</button>
        </form>

        <?php if ($error_msg): ?>
            <div class="error"><?php echo $error_msg; ?></div>
        <?php endif; ?>
    </div>
</div>

</body>
</html>