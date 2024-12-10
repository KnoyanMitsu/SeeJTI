<?php
header("Access-Control-Allow-Methods: POST");
header("Content-Type: application/json");
include 'core.php';
require './config/database.php';

$pdo = connectDatabase();

$response = [
    'status' => 'error',
    'message' => 'Invalid request',
];

function isAdmin($userLevel) {
    return $userLevel === 'Admin';
}

$method = $_SERVER['REQUEST_METHOD'];

if ($method === 'POST') {
    $data = json_decode(file_get_contents("php://input"), true);

    // Validasi input
    if (!isset($data['username'], $data['password'], $data['nama'], $data['nim'], $data['kelas'], $data['level'])) {
        die(json_encode([
            "status" => "error",
            "message" => "Invalid input user."
        ]));
    }

    // Validasi input
    if (!isset($data['username'], $data['password'], $data['nama'], $data['nim'], $data['kelas'], $data['level'])) {
        die(json_encode([
            "status" => "error",
            "message" => "Invalid input user."
        ]));
    }

    try {
        $params = [
            [$data['username'], SQLSRV_PARAM_IN],
            [md5($data['password']), SQLSRV_PARAM_IN],
            [$data['nama'], SQLSRV_PARAM_IN],
            [$data['nim'], SQLSRV_PARAM_IN],
            [$data['kelas'], SQLSRV_PARAM_IN],
            [$data['level'], SQLSRV_PARAM_IN],
        ];

        // Stored Procedure untuk Create User
        $sql = "{CALL CreateUser(?, ?, ?, ?, ?, ?)}";
        $stmt = sqlsrv_query($conn, $sql, $params);

        if ($stmt === false) {
            throw new Exception(print_r(sqlsrv_errors(), true));
        }

        $response['status'] = 'Sukses';
        $response['message'] = 'User berhasil ditambahkan.';
    } catch (Exception $e) {
        $response['message'] = 'Error: ' . $e->getMessage();
    }

    echo json_encode($response);
    exit;
}

http_response_code(405);
$response['message'] = 'Method not allowed.';
echo json_encode($response);
?>
