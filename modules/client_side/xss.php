<?php
// 1. Matikan XSS Protection di sisi Browser (WAJIB agar alert() muncul)
header("X-XSS-Protection: 0");

// 2. Simulasi Database Dokumentasi ADR Group
$documents = [
    "Panduan IT Security 2026",
    "Standard Operating Procedure Tangerang Infrastructure",
    "Konfigurasi Wazuh Agent Windows",
    "Dokumentasi Network Penetration Testing"
];

$search_query = isset($_GET['query']) ? $_GET['query'] : "";
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Vulnerable XSS Lab | Security Research</title>
    <style>
        body { font-family: sans-serif; background: #f4f4f4; padding: 50px; }
        .box { background: white; padding: 20px; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); max-width: 600px; margin: auto; }
        input[type="text"] { width: 80%; padding: 10px; border: 1px solid #ddd; }
        button { padding: 10px; background: #285A48; color: white; border: none; cursor: pointer; }
        .result { margin-top: 20px; padding: 15px; background: #e7f3ef; border-left: 5px solid #285A48; }
    </style>
</head>
<body>

<div class="box">
    <h2>Pencarian Internal ADRindo</h2>
    <form method="GET" action="">
        <input type="text" name="query" placeholder="Cari dokumen..." value="<?php echo $search_query; ?>">
        <button type="submit">Cari</button>
    </form>

    <?php if ($search_query !== ""): ?>
        <div class="result">
            <p>Hasil pencarian untuk: <strong><?php echo $search_query; ?></strong></p>
            <hr>
            <p style="color: #666;">Maaf, dokumen dengan kata kunci tersebut tidak ditemukan di server Tangerang.</p>
        </div>
    <?php endif; ?>
</div>

</body>
</html>