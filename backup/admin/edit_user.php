<?php
/**
 * LAB PENTEST: VULNERABLE EDIT PAGE
 * WARNING: Script ini hanya untuk keperluan belajar keamanan.
 * Celah: SQL Injection, IDOR, Stored XSS.
 */

require '../config/db.php';

$message = "";

// ❌ VULNERABLE 1: SQL Injection pada parameter GET 'id'
if (isset($_GET['id'])) {
    $id = $_GET['id']; 
    $sql = "SELECT * FROM users WHERE id = $id"; // Tidak menggunakan Prepared Statements
    $result = mysqli_query($conn, $sql);
    $user_data = mysqli_fetch_assoc($result);

    if (!$user_data) {
        die("User tidak ditemukan.");
    }
}

// ❌ VULNERABLE 2: SQL Injection pada proses Update
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id        = $_POST['id'];
    $full_name = $_POST['full_name'];
    $email     = $_POST['email'];
    $phone     = $_POST['phone'];
    $bio       = $_POST['bio'];
    $password  = $_POST['password'];

    if (!empty($password)) {
        $hashed = password_hash($password, PASSWORD_DEFAULT);
        // Query rentan SQLi
        $sql = "UPDATE users SET full_name='$full_name', email='$email', phone='$phone', bio='$bio', password='$hashed' WHERE id=$id";
    } else {
        $sql = "UPDATE users SET full_name='$full_name', email='$email', phone='$phone', bio='$bio' WHERE id=$id";
    }

    if (mysqli_query($conn, $sql)) {
        $message = "<div class='alert success'>✅ Data berhasil diupdate (Sistem Rentan)!</div>";
        // Mengambil ulang data tanpa filter (Stored XSS)
        $refresh = mysqli_query($conn, "SELECT * FROM users WHERE id=$id");
        $user_data = mysqli_fetch_assoc($refresh);
    } else {
        $message = "<div class='alert error'>❌ Error: " . mysqli_error($conn) . "</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit User (VULNERABLE) | Lab Pentest</title>
    <style>
        body { font-family: sans-serif; background: #1a1a1a; color: white; padding: 40px; }
        .card { background: #2d2d2d; padding: 20px; border-radius: 10px; max-width: 500px; margin: auto; }
        input, textarea { width: 100%; padding: 10px; margin: 10px 0; background: #444; color: white; border: 1px solid #555; }
        .btn { background: #3f7cff; border: none; padding: 10px 20px; color: white; cursor: pointer; width: 100%; }
        .alert { padding: 10px; margin-bottom: 20px; border-radius: 5px; text-align: center; }
        .success { background: #28a745; }
        .error { background: #dc3545; }
        .label { font-size: 12px; color: #aaa; }
    </style>
</head>
<body>

<div class="card">
    <h2>✏️ Edit User (Vulnerable)</h2>
    <p style="color: red; font-size: 11px;">Lab Mode: No sanitization active.</p>

    <?= $message ?>

    <form method="POST">
        <input type="hidden" name="id" value="<?= $user_data['id'] ?>">

        <div class="label">Username: <b><?= $user_data['username'] ?></b></div>
        
        <div class="label">Full Name:</div>
        <input type="text" name="full_name" value="<?= $user_data['full_name'] ?>">

        <div class="label">Email:</div>
        <input type="text" name="email" value="<?= $user_data['email'] ?>">

        <div class="label">Phone:</div>
        <input type="text" name="phone" value="<?= $user_data['phone'] ?>">

        <div class="label">Bio:</div>
        <textarea name="bio" rows="3"><?= $user_data['bio'] ?></textarea>

        <div class="label">Change Password (leave blank to keep current):</div>
        <input type="password" name="password">

        <button type="submit" class="btn">UPDATE DATA</button>
    </form>
    
    <br>
    <a href="users.php" style="color: #aaa; text-decoration: none; font-size: 12px;">⬅ Kembali ke List User</a>
</div>

</body>
</html>