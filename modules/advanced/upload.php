<?php
/**
 * Unrestricted File Upload Lab
 * Tema: #285A48 (Deep Green)
 * Kerentanan: No Extension Validation (RCE)
 */

$upload_dir = 'uploads/';
$message = "";
$status_class = "";

// Buat folder uploads jika belum ada
if (!is_dir($upload_dir)) {
    mkdir($upload_dir, 0777, true);
}

if (isset($_POST['submit'])) {
    $target_file = $upload_dir . basename($_FILES["fileToUpload"]["name"]);
    
    // KERENTANAN UTAMA: Tidak ada pengecekan ekstensi file (PHP, JS, EXE, dll diizinkan)
    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
        $message = "File berhasil diunggah ke: <a href='$target_file' target='_blank'>$target_file</a>";
        $status_class = "success";
    } else {
        $message = "Maaf, terjadi kesalahan saat mengunggah file.";
        $status_class = "danger";
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Unrestricted Uploader Lab | mrahmatt74</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        :root { --primary: #285A48; --accent: #3d846a; --bg: #f4f7f6; }
        body { font-family: 'Segoe UI', sans-serif; background: var(--bg); margin: 0; padding: 20px; }
        .container { max-width: 700px; margin: auto; }
        .card { background: white; padding: 30px; border-radius: 15px; box-shadow: 0 10px 25px rgba(0,0,0,0.1); border-top: 8px solid var(--primary); }
        .header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; color: var(--primary); }
        .status-box { padding: 15px; border-radius: 8px; margin-bottom: 20px; text-align: center; font-weight: bold; }
        .success { background: #d4edda; color: #155724; border: 1px solid #c3e6cb; }
        .danger { background: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; }
        .upload-area { border: 2px dashed var(--primary); padding: 40px; text-align: center; border-radius: 10px; background: #f9fbf9; cursor: pointer; transition: 0.3s; }
        .upload-area:hover { background: #f0f4f2; }
        .btn { padding: 12px 25px; border: none; border-radius: 5px; cursor: pointer; color: white; font-weight: bold; width: 100%; margin-top: 20px; }
        .btn-upload { background: var(--primary); }
        .hint { margin-top: 25px; padding: 15px; background: #fff3cd; border-left: 5px solid #ffca28; font-size: 0.9rem; color: #856404; }
        .btn-back { text-decoration: none; color: var(--primary); font-weight: bold; }
    </style>
</head>
<body>

<div class="container">
    <div class="header">
        <h2><i class="fas fa-cloud-upload-alt"></i> File Uploader</h2>
        <a href="../index.php" class="btn-back">← Dashboard</a>
    </div>

    <div class="card">
        <?php if ($message): ?>
            <div class="status-box <?php echo $status_class; ?>"><?php echo $message; ?></div>
        <?php endif; ?>

        <form action="" method="post" enctype="multipart/form-data">
            <div class="upload-area" onclick="document.getElementById('fileToUpload').click();">
                <i class="fas fa-file-import fa-3x" style="color: var(--primary); margin-bottom: 10px;"></i>
                <p id="file-name">Klik untuk pilih file atau drag & drop</p>
                <input type="file" name="fileToUpload" id="fileToUpload" style="display: none;" onchange="updateFileName()">
            </div>
            <button type="submit" name="submit" class="btn btn-upload">Unggah Sekarang</button>
        </form>

        <div class="hint">
            <strong>Tantangan Lab:</strong><br>
            Aplikasi ini tidak memiliki filter ekstensi file. Coba unggah file PHP sederhana untuk menjalankan perintah sistem (RCE).
            <br><br>
            <strong>Payload Contoh (shell.php):</strong><br>
            <code>&lt;?php echo system($_GET['cmd']); ?&gt;</code>
        </div>
    </div>
</div>

<script>
function updateFileName() {
    var input = document.getElementById('fileToUpload');
    var fileName = input.files[0].name;
    document.getElementById('file-name').innerHTML = "File terpilih: <strong>" + fileName + "</strong>";
}
</script>

</body>
</html>