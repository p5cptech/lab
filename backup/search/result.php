<?php
// Mengambil query dari parameter URL
$q = $_GET['q'] ?? '';
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SEARCH_MODULE | Wazuh Security Lab</title>
    <style>
        /* RETRO TERMINAL CSS - ULTRA LIGHTWEIGHT */
        :root {
            --bg-color: #121212;
            --amber: #ffb000;
            --amber-dim: #946b00;
            --border: #333;
        }

        * { 
            margin: 0; 
            padding: 0; 
            box-sizing: border-box; 
            font-family: 'Courier New', Courier, monospace; 
        }

        body {
            background-color: var(--bg-color);
            color: var(--amber);
            line-height: 1.4;
            /* Efek Scanline Terminal */
            background-image: linear-gradient(rgba(18, 16, 16, 0) 50%, rgba(0, 0, 0, 0.1) 50%);
            background-size: 100% 4px;
            min-height: 100vh;
            padding: 20px;
        }

        .header {
            border-bottom: 1px solid var(--amber);
            padding-bottom: 10px;
            margin-bottom: 30px;
            display: flex;
            justify-content: space-between;
        }

        .container {
            max-width: 800px;
            margin: 0 auto;
        }

        /* SEARCH WINDOW STYLE */
        .window {
            border: 1px solid var(--amber);
            background: #000;
            margin-bottom: 20px;
        }

        .window-header {
            background: var(--amber);
            color: #000;
            padding: 3px 10px;
            font-weight: bold;
            font-size: 0.8rem;
        }

        .window-body {
            padding: 20px;
        }

        /* FORM ELEMENTS */
        .search-input-group {
            display: flex;
            gap: 10px;
            margin-top: 10px;
        }

        input[type="text"] {
            flex: 1;
            background: #1a1a1a;
            border: 1px solid var(--amber-dim);
            padding: 10px;
            color: var(--amber);
            outline: none;
        }

        input[type="text"]:focus {
            border-color: var(--amber);
        }

        button {
            background: #000;
            color: var(--amber);
            border: 1px solid var(--amber);
            padding: 0 20px;
            cursor: pointer;
            font-weight: bold;
        }

        button:hover {
            background: var(--amber);
            color: #000;
        }

        /* RESULTS AREA */
        .result-box {
            margin-top: 20px;
            border-top: 1px dashed var(--amber-dim);
            padding-top: 20px;
        }

        .keyword-display {
            background: rgba(255, 176, 0, 0.1);
            padding: 10px;
            border-left: 3px solid var(--amber);
            margin-bottom: 20px;
        }

        .status-msg {
            color: #ff4444; /* Warna merah untuk tanda error/empty */
            text-align: center;
            padding: 20px;
            border: 1px dashed #ff4444;
        }

        footer {
            margin-top: 50px;
            text-align: center;
            font-size: 0.7rem;
            color: var(--amber-dim);
        }

        .blink {
            animation: blinker 1s linear infinite;
        }

        @keyframes blinker {
            50% { opacity: 0; }
        }
    </style>
</head>
<body>

<div class="container">
    <header class="header">
        <div>WAZUH_SEARCH_ENGINE v1.0</div>
        <div class="blink">● ONLINE</div>
    </header>

    <div class="window">
        <div class="window-header">SEARCH_DATABASE.EXE</div>
        <div class="window-body">
            <p>Masukkan parameter pencarian untuk memindai log sistem:</p>
            <form method="GET" class="search-input-group">
                <input type="text" name="q" placeholder="Cari log/payload..." value="<?php echo $q; ?>">
                <button type="submit">SCAN</button>
            </form>
        </div>
    </div>

    <?php if ($q !== ''): ?>
    <div class="window">
        <div class="window-header">QUERY_RESULTS.LOG</div>
        <div class="window-body">
            <div class="keyword-display">
                TARGET_KEYWORD: <strong><?php echo $q; ?></strong>
            </div>

            <div class="result-box">
                <div class="status-msg">
                    [ERROR] NO_MATCHES_FOUND: Keyword tidak ditemukan dalam database log aktif.
                </div>
            </div>
        </div>
    </div>
    <?php endif; ?>

    <footer>
        &copy; 2024 MRAHMATT74 - SOC_LAB_DIVISION
    </footer>
</div>

</body>
</html>