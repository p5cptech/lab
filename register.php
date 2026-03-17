<?php
session_start();

// Database connection - Sesuai folder Anda
include 'config/db.php';
include 'core/logger.php';

$error = '';
$success = '';
$profile_picture = 'default.png';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'] ?? '';
    $email    = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';
    $confirm_password = $_POST['confirm_password'] ?? '';
    $bio      = $_POST['bio'] ?? '';
    $role     = 'user';
    $profile_picture = 'default.png';

    // FILE UPLOAD VULNERABLE - Sengaja dibuat tanpa filter untuk lab Wazuh
    if (isset($_FILES['profile_picture']) && $_FILES['profile_picture']['error'] == 0) {
        $upload_dir = 'public/uploads/profiles/';
        
        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0777, true);
        }
        
        $file_name = $_FILES['profile_picture']['name'];
        $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
        $new_filename = $username . '_' . time() . '.' . $file_ext;
        $upload_path = $upload_dir . $new_filename;
        
        if (move_uploaded_file($_FILES['profile_picture']['tmp_name'], $upload_path)) {
            $profile_picture = $new_filename;
            if(function_exists('log_activity')) {
                log_activity("User $username mengunggah file: $file_name", "WARNING");
            }
        }
    }

    if ($password == $confirm_password) {
        // Rentan SQL Injection - Sengaja untuk simulasi
        $sql = "INSERT INTO users (id,username,email,password,bio,role,profile_picture,created_at) VALUES (NULL,'$username', '$email', '$password', '$bio', '$role', '$profile_picture', NOW())";
        
        if (mysqli_query($conn, $sql)) {
            $success = "Registrasi berhasil! Silakan login.";
        } else {
            $error = "Database Error: " . mysqli_error($conn);
        }
    } else {
        $error = "Password tidak cocok!";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - mrahmatt74 Lab</title>
    <link rel="stylesheet" href="public/assets/main.css">
    <link rel="stylesheet" href="public/assets/register.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body>

    <div class="auth-container">
        <div class="auth-card">
            <div class="auth-header">
                <h1><i class="fas fa-user-shield"></i> Daftar Akun</h1>
                <p>Authorized Access Only</p>
            </div>

            <?php if ($error): ?>
                <div class="alert alert-error">
                    <i class="fas fa-exclamation-triangle"></i> <?= $error; ?>
                </div>
            <?php endif; ?>

            <?php if ($success): ?>
                <div class="alert alert-success">
                    <i class="fas fa-check-circle"></i> <?= $success; ?>
                </div>
                <div style="text-align: center;">
                    <a href="login.php" class="btn-full" style="display:inline-block; text-decoration:none;">Ke Halaman Login</a>
                </div>
            <?php else: ?>

            <form method="POST" enctype="multipart/form-data">
                <div class="form-group">
                    <label><i class="fas fa-user"></i> Username</label>
                    <input type="text" name="username" placeholder="Masukkan username" required>
                </div>

                <div class="form-group">
                    <label><i class="fas fa-envelope"></i> Email</label>
                    <input type="email" name="email" placeholder="contoh@mail.com" required>
                </div>

                <div class="form-group">
                    <label><i class="fas fa-lock"></i> Password</label>
                    <input type="password" name="password" placeholder="Min. 6 karakter" required>
                </div>

                <div class="form-group">
                    <label><i class="fas fa-check-double"></i> Konfirmasi Password</label>
                    <input type="password" name="confirm_password" placeholder="Ulangi password" required>
                </div>

                <div class="form-group">
                    <label><i class="fas fa-image"></i> Foto Profil</label>
                    <input type="file" name="profile_picture">
                </div>

                <div class="form-group">
                    <label><i class="fas fa-id-card"></i> Bio</label>
                    <textarea name="bio" rows="2" placeholder="Ceritakan singkat tentang Anda"></textarea>
                </div>

                <button type="submit" class="btn-full">Daftar Sekarang</button>
            </form>

            <div class="auth-footer">
                Sudah punya akun? <a href="login.php">Login di sini</a>
            </div>
            <?php endif; ?>
        </div>
    </div>

</body>
</html>
