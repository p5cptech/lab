<?php
require('../config/db.php');
$id = $_GET['id'];

$post = mysqli_fetch_assoc(
    mysqli_query($conn, "SELECT * FROM blog_posts WHERE id=$id")
);

if ($_POST) {
    $title = $_POST['title'];
    $content = $_POST['content'];
    $author = $_POST['author'];

    mysqli_query($conn,
        "UPDATE blog_posts
         SET title='$title', content='$content', author='$author'
         WHERE id=$id"
    );

    header("Location: blog_list.php");
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Edit Blog</title>
<link rel="stylesheet" href="/assets/css/admin.css">
</head>
<body>

<h1 class="title">✏️ Edit Artikel</h1>

<div class="container single">
<form method="POST">
    <input name="title" value="<?= $post['title']; ?>">
    <input name="author" value="<?= $post['author']; ?>">
    <textarea name="content" rows="10"><?= $post['content']; ?></textarea>
    <button type="submit">Update</button>
</form>
</div>

</body>
</html>
