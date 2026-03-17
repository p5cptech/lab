<?php
include 'config/db.php';

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$query = "SELECT * FROM messages ORDER BY created_at DESC";
$result = mysqli_query($conn, $query);

?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>SOC Admin | Message Logs</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;800&display=swap" rel="stylesheet">
    <style>
        :root {
            --bg-deep: #020617;
            --card-bg: rgba(15, 23, 42, 0.6);
            --accent-blue: #38bdf8;
            --text-primary: #f1f5f9;
            --glass-border: rgba(255, 255, 255, 0.1);
        }
        body {
            background-color: var(--bg-deep);
            color: var(--text-primary);
            font-family: 'Plus Jakarta Sans', sans-serif;
            padding: 40px;
        }
        .admin-container { max-width: 1000px; margin: 0 auto; }
        h2 { border-left: 4px solid var(--accent-blue); padding-left: 15px; margin-bottom: 30px; }
        
        table {
            width: 100%;
            border-collapse: collapse;
            background: var(--card-bg);
            backdrop-filter: blur(10px);
            border-radius: 15px;
            overflow: hidden;
            border: 1px solid var(--glass-border);
        }
        th {
            background: rgba(56, 189, 248, 0.1);
            color: var(--accent-blue);
            text-align: left;
            padding: 15px;
            font-size: 0.8rem;
            text-transform: uppercase;
        }
        td {
            padding: 15px;
            border-bottom: 1px solid var(--glass-border);
            font-size: 0.9rem;
        }
        tr:hover { background: rgba(255,255,255,0.05); }
        .no-data { text-align: center; padding: 40px; color: #64748b; }
    </style>
</head>
<body>

<div class="admin-container">
    <h2>Inbound Security Messages (Database: sqli_lab)</h2>
    
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Waktu</th>
                <th>Pengirim</th>
                <th>Kontak</th>
                <th>Pesan/Log</th>
            </tr>
        </thead>
        <tbody>
            <?php if(mysqli_num_rows($result) > 0): ?>
                <?php while($row = mysqli_fetch_assoc($result)): ?>
                <tr>
                    <td><?php echo $row['id']; ?></td>
                    <td style="color: #94a3b8;"><?php echo $row['created_at']; ?></td>
                    <td><strong><?php echo $row['nama']; ?></strong></td>
                    <td><?php echo $row['email']; ?><br><small><?php echo $row['phone']; ?></small></td>
                    <td style="max-width: 300px;"><?php echo $row['message']; ?></td>
                </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr><td colspan="5" class="no-data">Belum ada pesan yang masuk.</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
    
    <br>
    <a href="index.php" style="color: var(--accent-blue); text-decoration: none; font-size: 0.8rem;">&larr; Kembali ke Lab</a>
</div>

</body>
</html>