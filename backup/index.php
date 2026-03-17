<?php
include 'config/db.php';
$status = "";
$server_ip = $_SERVER['SERVER_ADDR'] ?? '127.0.0.1';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama    = $_POST['nama'];
    $email   = $_POST['email'];
    $phone   = $_POST['phone'];
    $message = $_POST['message'];
    // Query tetap vuln untuk simulasi SIEM
    $sql = "INSERT INTO messages (nama, email, phone, message) VALUES ('$nama', '$email', '$phone', '$message')";
    if (mysqli_query($conn, $sql)) { $status = "success"; }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MRAHMATT74 | Security Operations Center</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>

<nav class="navbar">
    <div class="nav-container">
        <div class="logo">MRAHMATT<span>.SOC</span></div>
        <ul class="nav-menu">
            <li><a href="#">Simulations</a></li>
            <li><a href="#">Wazuh Rules</a></li>
            <li><a href="#">Lab Logs</a></li>
            <li><a href="#">Documentation</a></li>
        </ul>
    </div>
</nav>

<div class="container">
    <div class="hero">
        <div class="status-pill">> Wazuh Agent 001: Connected</div>
        <h1>Security Lab <span class="highlight">Environment</span></h1>
        <p>Platform simulasi serangan terkendali untuk pengujian deteksi SIEM, Integritas File, dan Respon Insiden.</p>
    </div>

    <div class="grid">
        <div class="card">
            <div class="card-header">OWASP A01:2021</div>
            <div class="card-body">
                <h3>Broken Access Control</h3>
                <p>Simulasi bypass login melalui SQL Injection dan IDOR. Pantau bagaimana Wazuh mendeteksi pola <i>single quote</i> dan <i>boolean-based</i>.</p>
                <a href="auth/login.php" class="btn">Launch Portal</a>
            </div>
        </div>

        <div class="card">
            <div class="card-header">OWASP A03:2021</div>
            <div class="card-body">
                <h3>Injection Commands</h3>
                <p>Eksekusi perintah sistem melalui alat diagnostik. Uji visibilitas perintah seperti <code>cat /etc/shadow</code> di terminal Wazuh.</p>
                <a href="tools/net.php" class="btn">Diagnostics Tool</a>
            </div>
        </div>

        <div class="card">
            <div class="card-header">OWASP A05:2021</div>
            <div class="card-body">
                <h3>Local File Inclusion</h3>
                <p>Uji kerentanan Path Traversal. Pantau alert log krtis ketika aplikasi mencoba mengakses direktori sensitif di luar root web.</p>
                <a href="files/view_doc.php?file=readme.txt" class="btn">File Browser</a>
            </div>
        </div>

        <div class="card">
            <div class="card-header">Injection</div>
            <div class="card-body">
                <h3>Reflected XSS</h3>
                <p>Simulasi pencurian sesi melalui script injection di URL. Validasi aturan <i>cross-site scripting</i> pada modul WAF Wazuh.</p>
                <a href="search/result.php?q=Cari+Sesuatu" class="btn">Search Engine</a>
            </div>
        </div>

        <div class="card">
            <div class="card-header">File Integrity</div>
            <div class="card-body">
                <h3>Web Shell Upload</h3>
                <p>Gunakan portal ini untuk mengunggah file. Skenario ideal untuk menguji <b>Real-time FIM</b> dan deteksi malware otomatis.</p>
                <a href="public/uploads.php" class="btn">Upload Center</a>
            </div>
        </div>

        <div class="card special">
            <div class="card-header">Centralized Monitoring</div>
            <div class="card-body">
                <h3>Wazuh Dashboard</h3>
                <p>Pusat kendali monitoring. Lihat visualisasi log, korelasi event, dan tingkat keparahan (severity) dari serangan yang dilakukan.</p>
                <a href="https://<?php echo $server_ip; ?>:8443" target="_blank" class="btn-special">Open SIEM Console</a>
            </div>
        </div>
    </div>

    <div id="contact" class="form-container">
        <div class="form-header">Hubungi Security Lab</div>
        <p>Gunakan formulir ini untuk mengirimkan laporan simulasi atau pertanyaan terkait lab.</p>
        
        <form action="" method="POST" class="retro-form">
            <div class="form-row">
                <div class="field">
                    <label>NAMA LENGKAP</label>
                    <input type="text" name="nama" placeholder="Masukkan nama..." required>
                </div>
                <div class="field">
                    <label>EMAIL</label>
                    <input type="email" name="email" placeholder="email@instansi.com" required>
                </div>
            </div>
            <div class="field">
                <label>NOMOR TELEPON</label>
                <input type="tel" name="phone" placeholder="+62 8xx..." required>
            </div>
            <div class="field">
                <label>PESAN / LOG SIMULASI</label>
                <textarea name="message" rows="5" placeholder="Tuliskan pesan atau log..." required></textarea>
            </div>
            <button type="submit" class="btn-submit">Kirim Pesan Sekarang</button>
        </form>
    </div>

    <footer>
        &copy; 2024 MRAHMATT74 Security Lab. Built for Educational Pentesting and SIEM Detection Research.
    </footer>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<?php if($status === "success"): ?>
<script>
    Swal.fire({ title: 'TERKIRIM', text: 'Data disimpan di database sqli_lab.', icon: 'success', background: '#222', color: '#ffb000' });
</script>
<?php endif; ?>
</body>
</html>