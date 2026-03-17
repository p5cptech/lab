<?php
require('../config/db.php');
$id = $_GET['id'];

$q = mysqli_query($conn, "SELECT * FROM blog_posts WHERE id=$id");
$post = mysqli_fetch_assoc($q);
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title><?= $post['title']; ?></title>
<link rel="stylesheet" href="/assets/css/blog.css">
</head>
<body>

<div class="container single">
    <h1><?= $post['title']; ?></h1>
    <small>By <?= $post['author']; ?> • <?= $post['created_at']; ?></small>
    <hr>
    <div class="content">
        <?= $post['content']; ?>
    </div>
</div>

</body>
</html>
