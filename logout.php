<?php
session_start();

// 1. Hapus semua data Session
session_unset();
session_destroy();

// 2. Hapus Cookie dengan mengatur waktu expired ke masa lalu
if (isset($_COOKIE['user_auth'])) {
    setcookie('user_auth', '', time() - 3600, '/');
}
if (isset($_COOKIE['user_session'])) {
    setcookie('user_session', '', time() - 3600, '/');
}

// 3. Redirect kembali ke Dashboard atau Login
header("Location: index.php");
exit;