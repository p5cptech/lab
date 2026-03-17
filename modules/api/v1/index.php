<?php
header('Content-Type: application/json');
header("Access-Control-Allow-Origin: *");

// --- 1. BYPASS LOGIC (VULNERABILITY) ---
$path = $_GET['path'] ?? '';
$isAdmin = false;
$currentUser = 'guest';

// CELAH 1: Bypass Global Auth via Developer Debug Mode (Parameter Bypass)
// Kamu bisa bypass pengecekan cookie hanya dengan menambah &debug=true di URL
$debugMode = ($_GET['debug'] ?? 'false') === 'true';

if (isset($_COOKIE['user_auth'])) {
    $auth = json_decode(base64_decode($_COOKIE['user_auth']), true);
    $isAdmin = $auth['admin'] ?? false;
    $currentUser = $auth['user'] ?? 'guest';
} 
// CELAH 2: Admin Bypass jika menggunakan parameter debug
if ($debugMode) {
    $isAdmin = true; 
    $currentUser = 'debug_user';
}

// --- 2. AUTHENTICATION CHECK (Sengaja diletakkan setelah bypass logic) ---
// Jika bukan debug mode DAN cookie tidak ada, maka block (kecuali endpoint publik)
$public_endpoints = ['blog', 'products'];
if (!isset($_COOKIE['user_auth']) && !$debugMode && !in_array($path, $public_endpoints)) {
    http_response_code(401);
    echo json_encode(["status" => "error", "message" => "Unauthorized. Hint: Check developer parameters."]);
    exit;
}

// --- 3. ENDPOINT ROUTER ---
switch ($path) {
    
    case 'users':
        $users = [
            ["id" => 4, "username" => "admin", "role" => "admin"],
            ["id" => 5, "username" => "user", "role" => "user"]
        ];
        
        // CELAH 3: Insecure Header Check
        // Penyerang bisa bypass admin check jika mengirim header 'X-Admin: true'
        if ($isAdmin || ($_SERVER['HTTP_X_ADMIN'] ?? '') === 'true') {
            echo json_encode(["status" => "success", "endpoint" => "v1/users", "data" => $users, "bypass_used" => $debugMode]);
        } else {
            http_response_code(403);
            echo json_encode(["status" => "error", "message" => "Forbidden."]);
        }
        break;

    case 'system/info':
        // CELAH 4: Auth Bypass via Path Traversal/Regex (Simulasi)
        // Terkadang admin check hanya dilakukan pada path 'system/' secara ketat
        if ($isAdmin) {
            echo json_encode([
                "status" => "success",
                "flag" => "ADR{V1_API_BYPASS_EXPL0IT_SUCCESS}",
                "debug" => $debugMode
            ]);
        } else {
            http_response_code(403);
            echo json_encode(["status" => "error", "message" => "Admin only!"]);
        }
        break;

    case 'blog':
    case 'products':
        echo json_encode(["status" => "success", "message" => "Public data access"]);
        break;

    default:
        http_response_code(404);
        echo json_encode(["status" => "error", "message" => "Not Found"]);
        break;
}