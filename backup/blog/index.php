<?php
require('../config/db.php');
$result = mysqli_query($conn, "SELECT * FROM blog_posts ORDER BY id DESC");
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Blog | Wazuh Security Lab</title>
<link rel="stylesheet" href="/assets/css/blog.css">
</head>
<body>

<h1 class="title">📰 Security Blog</h1>

<div class="container">
<?php while($row = mysqli_fetch_assoc($result)): ?>
    <div class="card">
        <h2><?= $row['title']; ?></h2>
        <small>By <?= $row['author']; ?> • <?= $row['created_at']; ?></small>
        <p><?= substr(strip_tags($row['content']), 0, 150); ?>...</p>
        <a href="view.php?id=<?= $row['id']; ?>">Read More →</a>
    </div>
<?php endwhile; ?>
</div>

</body>
</html>
