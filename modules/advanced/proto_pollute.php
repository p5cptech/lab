<?php
/**
 * Prototype Pollution Lab
 * Tema: #285A48 (Deep Green)
 * Deskripsi: Eksploitasi pada Client-side JS untuk memanipulasi objek global.
 */
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Prototype Pollution Lab | mrahmatt74</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        :root { --primary: #285A48; --accent: #3d846a; --bg: #f0f2f1; }
        body { font-family: 'Segoe UI', sans-serif; background: var(--bg); margin: 0; padding: 20px; }
        .container { max-width: 850px; margin: auto; }
        .header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; color: var(--primary); }
        .card { background: white; padding: 30px; border-radius: 15px; box-shadow: 0 10px 25px rgba(0,0,0,0.1); border-top: 8px solid var(--primary); }
        .status-box { padding: 15px; border-radius: 8px; margin-bottom: 20px; font-weight: bold; text-align: center; border: 1px solid #ccc; }
        .admin-access { background: #d4edda; color: #155724; border-color: #c3e6cb; display: none; }
        .user-access { background: #e2e3e5; color: #383d41; }
        .debug-box { background: #2d2d2d; color: #a9ffad; padding: 15px; border-radius: 8px; font-family: monospace; margin-top: 15px; }
        .hint { margin-top: 25px; padding: 15px; background: #fff3cd; border-left: 5px solid #ffca28; border-radius: 4px; color: #856404; }
        .btn-back { text-decoration: none; color: white; background: var(--primary); padding: 8px 15px; border-radius: 5px; }
    </style>
</head>
<body>

<div class="container">
    <div class="header">
        <h2><i class="fas fa-atom"></i> Prototype Pollution Lab</h2>
        <a href="../index.php" class="btn-back">Kembali</a>
    </div>

    <div class="card">
        <div id="access-status" class="status-box user-access">
            <i class="fas fa-user"></i> Status: Regular User
        </div>

        <div id="admin-panel" class="status-box admin-access">
            <i class="fas fa-user-shield"></i> Flag: <code>ADR{PR0T0_P0LLUT1ON_M4N1PULAT1ON}</code>
        </div>

        <h4>Objek Konfigurasi Saat Ini:</h4>
        <div id="debug-info" class="debug-box"></div>

        <div class="hint">
            <strong>Konsep Lab:</strong><br>
            Aplikasi ini menggabungkan parameter URL ke dalam objek konfigurasi menggunakan fungsi <code>merge()</code> yang tidak aman.
            <br><br>
            <strong>Tantangan:</strong><br>
            Gunakan properti <code>__proto__</code> untuk meracuni objek dasar (Object Prototype) agar properti <code>isAdmin</code> bernilai <code>true</code> secara global.
        </div>
    </div>
</div>

<script>
    // Fungsi merge yang rentan (Vulnerable Recursive Merge)
    function merge(target, source) {
        for (let key in source) {
            if (typeof target[key] === 'object' && typeof source[key] === 'object') {
                merge(target[key], source[key]);
            } else {
                target[key] = source[key];
            }
        }
    }

    // Mengambil parameter dari URL (misal: ?params={"a":1})
    const urlParams = new URLSearchParams(window.location.search);
    const paramsJson = urlParams.get('params');

    let config = { role: 'guest' }; // Objek dasar

    if (paramsJson) {
        try {
            const parsed = JSON.parse(paramsJson);
            merge(config, parsed); // Melakukan merge yang rentan
        } catch (e) {
            console.error("Invalid JSON");
        }
    }

    // LOGIKA PENGECEKAN (Ini yang akan dieksploitasi)
    // Jika isAdmin tidak didefinisikan di 'config', ia akan mencari ke Prototype
    if (config.isAdmin) {
        document.getElementById('access-status').style.display = 'none';
        document.getElementById('admin-panel').style.display = 'block';
    }

    // Tampilkan Debug Info
    document.getElementById('debug-info').innerHTML = `
        Config Object: ${JSON.stringify(config)}<br>
        Global isAdmin: ${config.isAdmin ? 'TRUE' : 'FALSE (undefined)'}
    `;
</script>

</body>
</html>