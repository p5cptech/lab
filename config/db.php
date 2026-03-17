<?php
$host = 'localhost';
$user = 'root';
$pass = 'P@ssw0rd';
$db   = 'mrahmatt74_lab';

$conn = mysqli_connect($host, $user, $pass, $db);

if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

?>