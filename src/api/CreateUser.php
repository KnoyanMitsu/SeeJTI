<?php
header("Content-Type: application/json");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Origin: *");

require './config/database.php';

$pdo = connectDatabase();

$response = [
    'status' => 'error',
    'message' => 'Invalid request',
];

$method = $_SERVER['REQUEST_METHOD'];

if ($method === 'POST') {
    $data = json_decode(file_get_contents("php://input"), true);

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
            ':password' => md5($data['password']),
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
