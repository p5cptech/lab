<?php
// OS Command Injection Lab (INTENTIONALLY VULNERABLE)

$output = "";
$target = $_POST["target"] ?? "";
$cmd    = "";

if ($_SERVER["REQUEST_METHOD"] === "POST" && !empty($target)) {

    if (stristr(PHP_OS, "WIN")) {
        $cmd = "ping " . $target;
    } else {
        $cmd = "ping -c 3 " . $target;
    }

    $output = shell_exec($cmd);
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Network Diagnostic Tool</title>

    <link rel="stylesheet" href="assets/css/lfi.css">
</head>

<body>

    <div class="container">

        <div class="header">
            <span>Network Diagnostic Tool</span>
            <span>Ping Utility</span>
        </div>

        <div class="body">

            <p class="desc">
                Tool ini digunakan untuk mengecek konektivitas jaringan menggunakan
                protokol ICMP. Masukkan alamat host atau IP untuk melakukan ping.
            </p>

            <form method="POST">

                <div class="input-row">

                    <input
                        type="text"
                        name="target"
                        placeholder="Contoh: 8.8.8.8"
                        value="<?= htmlspecialchars($target) ?>"
                    >

                    <button type="submit">
                        Run
                    </button>

                </div>

            </form>

            <?php if ($output || $_SERVER["REQUEST_METHOD"] === "POST"): ?>

                <div class="terminal">
                    <?= $output ?: "Host unreachable atau perintah gagal." ?>
                </div>

            <?php endif; ?>

            <div class="footer">

                Executed Command:

                <div class="command">
                    <?= htmlspecialchars($cmd ?: "None") ?>
                </div>

            </div>

        </div>

    </div>

</body>

</html>