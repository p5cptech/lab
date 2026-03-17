<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        body {
            background: #0f172a;
            font-family: Segoe UI, Tahoma, sans-serif;
            padding: 40px;
            color: #e5e7eb;
        }

        .container {
            max-width: 700px;
            margin: auto;
            background: #1e293b;
            border-radius: 8px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.5);
            overflow: hidden;
        }

        .header {
            background: #020617;
            padding: 12px 18px;
            font-weight: bold;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .header span {
            color: #22c55e;
        }

        .body {
            padding: 20px;
        }

        .desc {
            margin-bottom: 20px;
            line-height: 1.5;
            color: #cbd5f5;
        }

        .input-row {
            display: flex;
            gap: 10px;
        }

        input[type="text"] {
            flex: 1;
            padding: 10px;
            border: none;
            border-radius: 4px;
            background: #0f172a;
            color: white;
            outline: none;
        }

        button {
            background: #22c55e;
            border: none;
            padding: 10px 16px;
            border-radius: 4px;
            cursor: pointer;
            font-weight: bold;
        }

        button:hover {
            background: #16a34a;
        }

        .terminal {
            margin-top: 20px;
            background: black;
            color: #22c55e;
            padding: 15px;
            border-radius: 4px;
            font-family: monospace;
            white-space: pre-wrap;
            min-height: 150px;
            overflow: auto;
        }

        .footer {
            margin-top: 15px;
            font-size: 12px;
            color: #94a3b8;
        }

        .command {
            background: #020617;
            padding: 8px;
            border-radius: 4px;
            font-family: monospace;
            margin-top: 5px;
        }

        .back {
            margin-top: 20px;
            text-align: right;
        }

        .back a {
            color: #38bdf8;
            text-decoration: none;
        }

        .back a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container">

        <div class="header">
            <span>Network Diagnostic Tool</span>
            <span>Ping Utility</span>
        </div>

        <div class="body">

            <p class="desc">
                Tool ini digunakan untuk melakukan pengecekan konektivitas jaringan menggunakan
                protokol ICMP. Masukkan alamat host atau IP untuk memulai proses ping.
            </p>

            <form method="POST">

                <div class="input-row">

                    <input
                        type="text"
                        name="target"
                        placeholder="Contoh: 8.8.8.8 atau google.com"
                        value="<?= htmlspecialchars($target) ?>"
                    >

                    <button type="submit">Run</button>

                </div>

            </form>

            <?php if ($output || $_SERVER["REQUEST_METHOD"] === "POST"): ?>

                <div class="terminal">
                    <?= $output ?: "Host unreachable atau perintah gagal dijalankan." ?>
                </div>

            <?php endif; ?>

            <div class="footer">

                Executed Command:

                <div class="command">
                    <?= htmlspecialchars($cmd ?: "None") ?>
                </div>

            </div>

            <div class="back">
                <a href="../admin/index.php">← Kembali ke Dashboard</a>
            </div>

        </div>

    </div>
</body>
</html>