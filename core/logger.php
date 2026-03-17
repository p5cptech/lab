<?php
// core/logger.php

function log_activity($message, $level = "INFO") {
    // Tentukan jalur file log (Pastikan permissions sudah 775/777)
    $log_file = '/var/www/mrahmatt74/logs/pentest_access.log';
    
    // Format waktu: [2026-03-16 11:15:00]
    $timestamp = date('Y-m-d H:i:s');
    
    // Ambil IP Address penyerang/user
    $ip_address = $_SERVER['REMOTE_ADDR'];
    
    // Format log agar mudah dibaca Wazuh (JSON lebih disarankan)
    $log_entry = json_encode([
        "timestamp" => $timestamp,
        "level" => $level,
        "ip" => $ip_address,
        "message" => $message,
        "user_agent" => $_SERVER['HTTP_USER_AGENT']
    ]);

    // Tulis ke file log
    file_put_contents($log_file, $log_entry . PHP_EOL, FILE_APPEND);
}
?>