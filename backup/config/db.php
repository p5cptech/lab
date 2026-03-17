<?php
$host = "localhost";
$user = "root";
$pass = "P@ssw0rd";
$db   = "sqli_lab";

$conn = mysqli_connect($host, $user, $pass, $db);

if (!$conn) {
    die("DB Error");
} 
