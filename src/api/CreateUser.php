<?php
header("Content-Type: application/json");
header("Access-Control-Allow-Methods: POST");
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

    $userLevel = $data['user_level'] ?? null;

    if (!isAdmin($userLevel)) {
        http_response_code(403);
        $response['message'] = 'Access denied. Only Admin can perform this action.';
        echo json_encode($response);
        exit;
    }

    if (!isset($data['username'], $data['password'], $data['nama'], $data['nim'], $data['kelas'], $data['level'])) {
        $response['message'] = 'All fields are required.';
        echo json_encode($response);
        exit;
    }

    try {
        $sql = "INSERT INTO [SeeJTI].[dbo].[users] 
                    (username, password, nama, nim, kelas, level)
                    VALUES (:username, :password, :nama, :nim, :kelas, :level)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':username' => $data['username'],
            ':password' => $data['password'],
            ':nama' => $data['nama'],
            ':nim' => $data['nim'],
            ':kelas' => $data['kelas'],
            ':level' => $data['level'],
        ]);

        $response['status'] = 'Sukses';
        $response['message'] = 'Mahasiswa Berhasil Terdaftar.';
    } catch (PDOException $e) {
        $response['message'] = 'Error: ' . $e->getMessage();
    }

    echo json_encode($response);
    exit;
}

http_response_code(405);
$response['message'] = 'Method not allowed.';
echo json_encode($response);
