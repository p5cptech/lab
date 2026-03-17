<?php
// core/auth.php

function is_logged_in() {
    return isset($_SESSION['user_id']);
}

function restrict_to_admin() {
    if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
        // Log kejadian ini ke Wazuh karena ada akses ilegal
        log_activity("Unauthorized access attempt by User ID: " . ($_SESSION['user_id'] ?? 'Guest'), "WARNING");
        
        header("Location: ../index.php?error=unauthorized");
        exit();
    }
}

function logout() {
    session_destroy();
    header("Location: ../login.php");
    exit();
}
?>