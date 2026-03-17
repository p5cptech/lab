<?php
header("X-XSS-Protection: 0");
$search = $_GET['search'] ?? "";
?>

<!DOCTYPE html>
<html>
<head>
    <title>Reflected XSS</title>
    <link rel="stylesheet" href="../../public/assets/xss.css">
</head>
<body>

<div class="container">
    <div class="card">
        <h2>Reflected XSS</h2>

        <form method="GET">
            <input type="text" name="search" value="<?= $search ?>" placeholder="Cari...">
            <button>Cari</button>
        </form>

        <?php if($search): ?>
            <div class="result-info">
                Hasil untuk: <b><?= $search ?></b>
            </div>
        <?php endif; ?>

        <div class="payload-hint">
            <strong>Payload:</strong>
            <code>?search=&lt;script&gt;alert('XSS')&lt;/script&gt;</code>
        </div>

    </div>
</div>

</body>
</html>