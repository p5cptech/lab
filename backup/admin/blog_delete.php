<?php
require('../config/db.php');
$id = $_GET['id'];

mysqli_query($conn, "DELETE FROM blog_posts WHERE id=$id");

header("Location: blog_list.php");
