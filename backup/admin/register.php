<?php
/**
 * SECURE USER REGISTRATION - LAB PENTEST EDITION
 * Theme: Midnight Blue
 * Features: Strong Password Validation, Duplicate Check, Back Navigation
 */

require '../config/db.php'; 

$message = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username  = trim($_POST['username']);
    $password  = $_POST['password'];
    $full_name = trim($_POST['full_name']);
    $email     = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);
    $phone_raw = trim($_POST['phone']); 
    $bio       = trim($_POST['bio']);

    // Regex Password: Min 8 char, 1 Up, 1 Low, 1 Num, 1 Symbol
    $password_regex = "/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).{8,}$/";

    if (empty($username) || empty($password)) {
        $message = "<div class='alert error'>❌ Username dan Password wajib diisi.</div>";
    } 
    elseif (!preg_match($password_regex, $password)) {
        $message = "<div class='alert error'>❌ Password harus: 8+ karakter, Huruf Besar/Kecil, Angka, & Simbol!</div>";
    }
    elseif (!ctype_digit($phone_raw) && !empty($phone_raw)) {
        $message = "<div class='alert error'>❌ Nomor telepon harus berupa angka saja!</div>";
    }
    else {
        $phone = filter_var($phone_raw, FILTER_SANITIZE_NUMBER_INT);

        // 1. CEK DUPLIKASI
        $check_sql = "SELECT username, email FROM users WHERE username = ? OR email = ? LIMIT 1";
        $check_stmt = mysqli_prepare($conn, $check_sql);
        mysqli_stmt_bind_param($check_stmt, "ss", $username, $email);
        mysqli_stmt_execute($check_stmt);
        $result = mysqli_stmt_get_result($check_stmt);

        if (mysqli_num_rows($result) > 0) {
            $existing = mysqli_fetch_assoc($result);
            $field = ($existing['username'] === $username) ? "Username" : "Email";
            $message = "<div class='alert error'>❌ $field sudah terdaftar!</div>";
        } else {
            // 2. PROSES INSERT
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $sql = "INSERT INTO users (username, password, full_name, email, phone, bio) VALUES (?, ?, ?, ?, ?, ?)";
            
            if ($stmt = mysqli_prepare($conn, $sql)) {
                mysqli_stmt_bind_param($stmt, "ssssss", $username, $hashed_password, $full_name, $email, $phone, $bio);
                
                if (mysqli_stmt_execute($stmt)) {
                    $message = "<div class='alert success'>✅ Akun <b>$username</b> berhasil didaftarkan!</div>";
                } else {
                    $message = "<div class='alert error'>❌ Error: " . mysqli_error($conn) . "</div>";
                }
                mysqli_stmt_close($stmt);
            }
        }
        mysqli_stmt_close($check_stmt);
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Secure Register | Admin Glow</title>
    <style>
        * { box-sizing: border-box; font-family: 'Segoe UI', system-ui, sans-serif; }
        
        body {
            margin: 0; min-height: 100vh;
            background: radial-gradient(circle at top, #0a1432, #050b1e);
            display: flex; align-items: center; justify-content: center;
            color: #e6edf3; padding: 20px;
        }

        .card {
            width: 100%; max-width: 650px;
            background: rgba(10, 20, 50, 0.95); /* Theme Color Requested */
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 20px; padding: 40px;
            box-shadow: 0 25px 50px rgba(0,0,0,0.5);
            backdrop-filter: blur(10px);
        }

        .card-header {
            display: flex; justify-content: space-between; align-items: center;
            margin-bottom: 30px; border-bottom: 1px solid rgba(255,255,255,0.05);
            padding-bottom: 15px;
        }

        .card-title { font-size: 24px; font-weight: 600; color: #fff; margin: 0; }

        /* Tombol Back */
        .btn-back {
            text-decoration: none; color: #4facfe; font-size: 14px;
            font-weight: 500; transition: 0.3s;
        }
        .btn-back:hover { color: #00f2fe; text-shadow: 0 0 8px rgba(79, 172, 254, 0.5); }

        .form-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; }
        .form-group { margin-bottom: 15px; }
        label { display: block; font-size: 13px; color: #9fb3ff; margin-bottom: 8px; }

        input, textarea {
            width: 100%; padding: 12px; border-radius: 10px;
            border: 1px solid rgba(255,255,255,0.1); background: #050b1e;
            color: #fff; font-size: 14px; outline: none; transition: 0.2s;
        }
        input:focus { border-color: #4facfe; box-shadow: 0 0 0 3px rgba(79, 172, 254, 0.1); }

        /* Hint Password */
        .pwd-hint {
            grid-column: span 2; font-size: 11px; color: #8a9fcb;
            background: rgba(255,255,255,0.03); padding: 10px; border-radius: 8px;
        }

        .btn-submit {
            width: 100%; padding: 14px; 
            background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
            border: none; border-radius: 10px; color: #000;
            font-size: 15px; font-weight: bold; cursor: pointer;
            margin-top: 20px; transition: 0.3s;
        }
        .btn-submit:hover { transform: translateY(-2px); box-shadow: 0 10px 20px rgba(79, 172, 254, 0.3); }

        .alert { padding: 15px; border-radius: 10px; margin-bottom: 25px; font-size: 14px; text-align: center; border: 1px solid; }
        .success { background: rgba(63, 185, 80, 0.1); color: #3fb950; border-color: #238636; }
        .error { background: rgba(248, 81, 73, 0.1); color: #f85149; border-color: #da3633; }

        @media (max-width: 600px) { .form-grid { grid-template-columns: 1fr; } .pwd-hint { grid-column: span 1; } }
    </style>
</head>
<body>

<div class="card">
    <div class="card-header">
        <h1 class="card-title">🛡️ Register Secure</h1>
        <a href="users.php" class="btn-back">⬅ Back to Users</a>
    </div>

    <?php echo $message; ?>

    <form method="POST" id="regForm">
        <div class="form-grid">
            <div class="form-group">
                <label>Username</label>
                <input type="text" name="username" required placeholder="Contoh: rahmat_sec">
            </div>
            <div class="form-group">
                <label>Email Address</label>
                <input type="email" name="email" placeholder="admin@lab.com">
            </div>

            <div class="pwd-hint">
                💡 <b>Strong Password Required:</b> Minimal 8 karakter, harus mengandung Huruf Besar, Huruf Kecil, Angka, dan Simbol.
            </div>

            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" id="password" required placeholder="••••••••">
            </div>
            <div class="form-group">
                <label>Full Name</label>
                <input type="text" name="full_name" placeholder="Nama Lengkap">
            </div>
            <div class="form-group">
                <label>Phone Number</label>
                <input type="text" name="phone" id="phone" placeholder="08xxxx">
            </div>
            <div class="form-group">
                <label>Bio</label>
                <textarea name="bio" rows="2" placeholder="Tell something about you..."></textarea>
            </div>
        </div>
        <button type="submit" class="btn-submit">CREATE ACCOUNT</button>
    </form>
</div>

<script>
    // Hanya angka untuk phone
    document.getElementById('phone').addEventListener('input', function (e) {
        this.value = this.value.replace(/[^0-9]/g, '');
    });

    // Validasi Client-side sebelum kirim
    document.getElementById('regForm').onsubmit = function() {
        const pwd = document.getElementById('password').value;
        const phone = document.getElementById('phone').value;
        
        // Regex yang sama dengan PHP
        const pwdRegex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).{8,}$/;
        
        if (!pwdRegex.test(pwd)) {
            alert("Password belum cukup kuat! Gunakan kombinasi Huruf Besar, Kecil, Angka, dan Simbol.");
            return false;
        }

        if (phone !== "" && !/^\d+$/.test(phone)) {
            alert("Nomor telepon harus angka!");
            return false;
        }
        return true;
    };
</script>

</body>
</html>