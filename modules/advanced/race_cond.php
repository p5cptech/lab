<?php
/**
 * Race Condition Lab (Custom Amount)
 * Target: Menarik saldo melebihi batas 100.000 dengan request bersamaan.
 */

session_start();

// Inisialisasi saldo jika belum ada
if (!isset($_SESSION['balance'])) {
    $_SESSION['balance'] = 100000;
    $_SESSION['logs'] = [];
}

$message = "";
$status_class = "";

if (isset($_POST['withdraw'])) {
    $amount = intval($_POST['amount']);
    
    if ($amount <= 0) {
        $message = "Nominal tidak valid!";
        $status_class = "danger";
    } else {
        // --- TITIK KERENTANAN: TIME OF CHECK (TOC) ---
        // Server memeriksa saldo sebelum melakukan pengurangan
        if ($_SESSION['balance'] >= $amount) {
            
            // Simulasi delay pemrosesan server (Jendela kerentanan)
            // Memberikan waktu bagi request kedua untuk masuk sebelum saldo berkurang
            usleep(300000); // 0.3 detik

            // --- TITIK KERENTANAN: TIME OF USE (TOU) ---
            $_SESSION['balance'] -= $amount;
            
            $log_entry = "Berhasil menarik Rp" . number_format($amount) . " pada " . date('H:i:s.u');
            $_SESSION['logs'][] = $log_entry;
            
            $message = "Penarikan Rp" . number_format($amount) . " Berhasil!";
            $status_class = "success";
        } else {
            $message = "Saldo Tidak Mencukupi!";
            $status_class = "danger";
        }
    }
}

// Reset Lab
if (isset($_POST['reset'])) {
    $_SESSION['balance'] = 100000;
    $_SESSION['logs'] = [];
    header("Location: race_cond.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Race Condition Lab | mrahmatt74</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        :root { --primary: #285A48; --bg: #f4f7f6; }
        body { font-family: 'Segoe UI', sans-serif; background: var(--bg); padding: 20px; }
        .container { max-width: 600px; margin: auto; }
        .card { background: white; padding: 30px; border-radius: 15px; box-shadow: 0 10px 25px rgba(0,0,0,0.1); border-top: 8px solid var(--primary); }
        .balance-box { background: var(--primary); color: white; padding: 20px; border-radius: 10px; text-align: center; margin-bottom: 20px; }
        .status-box { padding: 15px; border-radius: 8px; margin-bottom: 20px; text-align: center; font-weight: bold; }
        .success { background: #d4edda; color: #155724; }
        .danger { background: #f8d7da; color: #721c24; }
        input[type="number"] { width: 100%; padding: 12px; border: 2px solid #eee; border-radius: 8px; margin-bottom: 15px; font-size: 16px; }
        .log-container { background: #1e1e1e; color: #00ff00; padding: 15px; border-radius: 8px; font-family: 'Courier New', monospace; height: 180px; overflow-y: auto; font-size: 13px; line-height: 1.6; }
        .btn { padding: 12px; border: none; border-radius: 8px; cursor: pointer; color: white; font-weight: bold; width: 100%; font-size: 16px; transition: 0.3s; }
        .btn-withdraw { background: var(--primary); margin-bottom: 10px; }
        .btn-withdraw:hover { background: #1e4537; }
        .btn-reset { background: #6c757d; }
    </style>
</head>
<body>

<div class="container">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
        <h2 style="color: var(--primary);"><i class="fas fa-bolt"></i> Race Condition Lab</h2>
        <a href="../index.php" style="text-decoration: none; color: #666;">← Dashboard</a>
    </div>

    <div class="card">
        <div class="balance-box">
            <p style="margin:0; opacity: 0.8;">Saldo Saat Ini</p>
            <h1 style="margin:5px 0 0 0;">Rp<?php echo number_format($_SESSION['balance']); ?></h1>
        </div>

        <?php if ($message): ?>
            <div class="status-box <?php echo $status_class; ?>"><?php echo $message; ?></div>
        <?php endif; ?>

        <form method="POST">
            <label style="display:block; margin-bottom: 8px; font-weight: bold; color: #444;">Nominal Penarikan (Rp):</label>
            <input type="number" name="amount" value="100000" min="1" step="1" required>
            <button type="submit" name="withdraw" class="btn btn-withdraw">Tarik Tunai</button>
        </form>
        
        <form method="POST">
            <button type="submit" name="reset" class="btn btn-reset">Reset Lab</button>
        </form>

        <h4 style="margin: 25px 0 10px 0; color: #444;"><i class="fas fa-history"></i> Audit Log Transaksi:</h4>
        <div class="log-container">
            <?php 
            if (empty($_SESSION['logs'])) echo "> <span style='color:#888'>Menunggu transaksi...</span>";
            foreach (array_reverse($_SESSION['logs']) as $log) {
                echo "> " . htmlspecialchars($log) . "<br>";
            }
            ?>
        </div>
    </div>
</div>

</body>
</html>