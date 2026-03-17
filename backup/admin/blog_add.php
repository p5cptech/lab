<?php
require('../config/db.php');

if ($_POST) {
    $title = $_POST['title'];
    $content = $_POST['content'];
    $author = $_POST['author'];

    mysqli_query($conn,
        "INSERT INTO blog_posts (title, content, author)
         VALUES ('$title','$content','$author')"
    );

    header("Location: blog_list.php");
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Add Blog</title>
<link rel="stylesheet" href="/assets/css/admin.css">
</head>
<body>

<h1 class="title">✍️ Tambah Artikel</h1>

<div class="container single">
<form method="POST">
    <input name="title" placeholder="Judul" required>
    <input name="author" placeholder="Author" required>
    <textarea name="content" rows="10" placeholder="Isi artikel..." required></textarea>
    <button type="submit">Publish</button>
</form>
</div>

</body>
</html>
