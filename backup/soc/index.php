<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>SOC Monitoring Dashboard</title>
    <style>
        :root {
            --bg-dark: #0a0e14; /* Warna latar belakang gelap */
            --card-bg: #111821; /* Warna kartu/kontainer */
            --neon-blue: #4dc3ff; /* Warna biru neon dari gambar */
            --text-main: #ffffff;
            --text-dim: #a0a0a0;
        }

        body {
            background-color: var(--bg-dark);
            color: var(--text-main);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 20px;
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
        }

        .header h1 {
            font-size: 2.5em;
            margin-bottom: 5px;
            letter-spacing: 2px;
        }

        .header span {
            color: var(--neon-blue);
            text-transform: uppercase;
        }

        .status-bar {
            background: rgba(77, 195, 255, 0.1);
            border: 1px solid var(--neon-blue);
            padding: 5px 15px;
            border-radius: 20px;
            display: inline-block;
            font-size: 0.9em;
            color: #00ff88; /* Hijau seperti status 'Connected' di gambar */
        }

        .dashboard-container {
            display: grid;
            grid-template-columns: 1fr;
            gap: 20px;
            max-width: 1200px;
            margin: 0 auto;
        }

        .card {
            background-color: var(--card-bg);
            border-radius: 8px;
            padding: 15px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.5);
            border-top: 3px solid var(--neon-blue);
        }

        .card-title {
            font-size: 1.1em;
            font-weight: bold;
            margin-bottom: 15px;
            display: flex;
            justify-content: space-between;
        }

        iframe {
            border: none;
            border-radius: 4px;
            width: 100%;
            height: 650px; /* Ditingkatkan agar lebih lega */
        }
    </style>
</head>
<body>

    <div class="header">
        <h1>SECURITY <span>MONITORING</span></h1>
        <div class="status-bar">● Wazuh Manager: Active</div>
    </div>

    <div class="dashboard-container">
        <div class="card">
            <div class="card-title">
                <span>WAZUH SIEM ALERTS</span>
                <span style="color: var(--text-dim); font-size: 0.8em;">Real-time Stream</span>
            </div>
            <iframe src="https://192.168.5.82:8443/app/dashboards#/view/74f91de0-fa56-11f0-8dd5-5929d76ce103?embed=true&_g=%28filters%3A%21%28%28%27%24state%27%3A%28store%3AglobalState%29%2Cmeta%3A%28alias%3A%21n%2Cdisabled%3A%21f%2Cindex%3A%27wazuh-alerts-%2A%27%2Ckey%3Amanager.name%2Cnegate%3A%21f%2Cparams%3A%28query%3Awazuh-server%29%2Ctype%3Aphrase%29%2Cquery%3A%28match_phrase%3A%28manager.name%3A%28query%3Awazuh-server%29%29%29%29%29%2CrefreshInterval%3A%28pause%3A%21t%2Cvalue%3A0%29%2Ctime%3A%28from%3Anow-0d%2Fd%2Cto%3Anow%29%29"></iframe>
        </div>
    </div>

</body>
</html>