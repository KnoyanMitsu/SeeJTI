<?php
require _DIR_ . '/config/database.php';

const SESSION_SECRET = 'seejtipolinema';

// Fungsi untuk mengeluarkan header JSON
function sendJsonResponse($data, $statusCode = 200) {
    header('Content-Type: application/json');
    http_response_code($statusCode);
    echo json_encode($data);
}

// Mulai sesi PHP
session_start();

// Cek metode HTTP yang digunakan
$method = $_SERVER['REQUEST_METHOD'];
$requestUri = $_SERVER['REQUEST_URI'];

$body = json_decode(file_get_contents('php://input'), true);

// User login
if ($method == 'POST' && $requestUri == '/login') {
    $username = $body['username'] ?? '';
    $password = $body['password'] ?? '';

    // Validasi username dan password
    if (empty($username) || empty($password)) {
        sendJsonResponse(["message" => "Username dan password harus diisi"], 400);
        exit;
    }

    // Get data dari database
    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = :username LIMIT 1");
    $stmt->execute(['username' => $username]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    // Cek password
    if (!$user || !password_verify($password, $user['password'])) {
        sendJsonResponse(["message" => "Username atau password salah atau tidak ditemukan"], 401);
        exit;
    }

    $_SESSION['username'] = $user['username'];

    setcookie("PHPSESSID", session_id(), [
        'expires' => time() + 3600,
        'httponly' => true,
        'secure' => true,
        'samesite' => 'Strict'
    ]);

    sendJsonResponse(["message" => "Login berhasil"]);
    exit;
}

// Autentikasi user
if ($method == 'GET' && $requestUri == '/protected') {
    if (!isset($_SESSION['username'])) {
        sendJsonResponse(["message" => "Anda harus login terlebih dahulu"], 401);
        exit;
    }

    sendJsonResponse([
        "message" => "Anda berhasil mengakses endpoint yang dilindungi!",
        "username" => $_SESSION['username']
    ]);
    exit;
}

// User logout
if ($method == 'POST' && $requestUri == '/logout') {
    session_unset();
    session_destroy();
    setcookie("PHPSESSID", "", time() - 3600, "/"); // Hapus cookie sesi

    sendJsonResponse(["message" => "Logout berhasil"]);
    exit;
}