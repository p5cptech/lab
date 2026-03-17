<?php
session_start();
include 'config/db.php';
include 'core/logger.php';

$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    // LOGGING UNTUK WAZUH
    log_activity("Percobaan login: Username $username", "INFO");

    // VULNERABLE QUERY (Tanpa Prepared Statement untuk keperluan Lab SQLi)
    $query = "SELECT * FROM users WHERE username = '$username' AND password = '$password'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) > 0) {
        $user = mysqli_fetch_assoc($result);

        // --- PENENTUAN STATUS ADMIN ---
        // admin = true jika role di DB adalah 'admin'
        $isAdmin = (strtolower($user['role']) === 'admin') ? true : false;

        // --- PEMBUATAN SESSION JSON ---
        $session_array = [
            "user" => $user['username'],
            "email" => $user['email'],
            "admin" => $isAdmin, // Boolean flag
            "iat" => time()      // Issued At (Waktu login)
        ];
        
        $encoded_session = base64_encode(json_encode($session_array));

        // Simpan ke cookie 'user_auth'
        setcookie('user_auth', $encoded_session, time() + 3600, "/", "", false, false);

        log_activity("Login Berhasil: " . $user['username'] . " (Admin: " . ($isAdmin ? 'Yes' : 'No') . ")", "SUCCESS");
        header("Location: index.php");
        exit();
    } else {
        log_activity("Login Gagal untuk username: $username", "ALERT");
        $error = "Username atau password salah!";
    }
}
?>     

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Lab - ADR Group Security</title>
    <link rel="stylesheet" href="public/assets/main.css">
    <link rel="stylesheet" href="public/assets/login.css">
</head>
<body>
    <div class="login-container">
        <div class="login-box">
            <div class="header">
                <h2>Login</h2>
                <p>Silakan masuk ke sistem</p>
            </div>
            
            <?php if($error): ?>
                <div class="error-msg"><?php echo $error; ?></div>
            <?php endif; ?>

            <form action="" method="POST">
                <div class="input-group">
                    <label>Username</label>
                    <input type="text" name="username" placeholder="Masukkan username" required>
                </div>
                <div class="input-group">
                    <label>Password</label>
                    <input type="password" name="password" placeholder="Masukkan password" required>
                </div>
                <button type="submit" class="btn-login">Masuk</button>
            </form>
            <div class="footer">
                <p>&copy; 2026 ADR Group Security Awareness</p>
            </div>
        </div>
    </div>
</body>
</html>