<?php
/**
 * Insecure Deserialization Lab
 * Tema: #285A48 (Deep Green)
 */

// Class simulasi untuk User Profile
class UserProfile {
    public $username;
    public $role;
    public $is_admin;

    public function __construct($user) {
        $this->username = $user;
        $this->role = "General User";
        $this->is_admin = false;
    }
}

// Inisialisasi awal
$message = "";
$status_class = "info";

// 1. Logika Deserialisasi (Vulnerability)
if (isset($_COOKIE['user_session'])) {
    // BAHAYA: Mengambil data dari cookie dan langsung di-unserialize tanpa validasi
    $data = base64_decode($_COOKIE['user_session']);
    $user_obj = unserialize($data);

    if ($user_obj && $user_obj->is_admin === true) {
        $message = "Akses Diterima! Flag: <code>ADR{D3s3r14l1zation_Obj3ct_Inject1on}</code>";
        $status_class = "success";
    } else {
        $message = "Halo " . htmlspecialchars($user_obj->username) . ". Anda tidak memiliki akses admin.";
        $status_class = "warning";
    }
} else {
    // Set cookie default jika belum ada
    $default_user = new UserProfile("mrahmatt74");
    $serialized_data = base64_encode(serialize($default_user));
    setcookie('user_session', $serialized_data, time() + 3600, "/");
    header("Location: insecure_des.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Insecure Deserialization Lab | mrahmatt74</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        :root { 
            --primary-color: #285A48; 
            --accent-color: #3d846a;
            --bg-color: #f0f2f1;
        }
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background: var(--bg-color); margin: 0; padding: 20px; }
        .container { max-width: 800px; margin: auto; }
        .header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; color: var(--primary-color); }
        .card { background: white; padding: 30px; border-radius: 15px; box-shadow: 0 10px 25px rgba(0,0,0,0.1); border-top: 8px solid var(--primary-color); }
        .status-box { padding: 15px; border-radius: 8px; margin-bottom: 20px; font-weight: 500; }
        .info { background: #e3f2fd; color: #0d47a1; border-left: 5px solid #2196f3; }
        .warning { background: #fff3cd; color: #856404; border-left: 5px solid #ffca28; }
        .success { background: #d4edda; color: #155724; border-left: 5px solid #28a745; }
        .debug-box { background: #2d2d2d; color: #a9ffad; padding: 15px; border-radius: 8px; font-family: 'Consolas', monospace; font-size: 0.85rem; overflow-x: auto; }
        .hint { margin-top: 25px; padding: 15px; background: #f9f9f9; border: 1px dashed var(--primary-color); border-radius: 8px; font-size: 0.9rem; }
        code { background: #e83e8c; color: white; padding: 2px 5px; border-radius: 4px; }
        .btn-back { text-decoration: none; color: white; background: var(--primary-color); padding: 8px 15px; border-radius: 5px; }
        .btn-back:hover { background: var(--accent-color); }
    </style>
</head>
<body>

<div class="container">
    <div class="header">
        <h2><i class="fas fa-microchip"></i> Insecure Deserialization Lab</h2>
        <a href="../index.php" class="btn-back"><i class="fas fa-arrow-left"></i> Kembali</a>
    </div>

    <div class="card">
        <div class="status-box <?php echo $status_class; ?>">
            <i class="fas fa-info-circle"></i> <?php echo $message; ?>
        </div>

        <h4>Objek User Saat Ini (Serialized):</h4>
        <div class="debug-box">
            <?php echo $_COOKIE['user_session']; ?>
        </div>

        <div class="hint">
            <strong>Lab Objective:</strong><br>
            Aplikasi ini menyimpan profil user di dalam cookie <code>user_session</code> dalam bentuk objek PHP yang di-serialize dan di-encode (Base64).
            <br><br>
            <strong>Misi:</strong> Manipulasi isi cookie tersebut agar property <code>is_admin</code> menjadi <code>true</code> untuk mendapatkan Flag.
        </div>

        <div style="margin-top: 20px; font-size: 0.8rem; color: #666;">
            <i class="fas fa-code"></i> <strong>Hint:</strong> Decode Base64 cookie tersebut, ubah <code>b:0;</code> menjadi <code>b:1;</code>, lalu encode kembali dan ganti cookie di browser kamu.
        </div>
    </div>
</div>

</body>
</html>