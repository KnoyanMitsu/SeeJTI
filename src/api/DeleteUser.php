<?php
header("Content-Type: application/json");
header("Access-Control-Allow-Methods: DELETE");
header("Access-Control-Allow-Origin: *");

include 'core.php';
require './config/database.php';

$pdo = connectDatabase();

$response = [
    'status' => 'error',
    'message' => 'Invalid request',
];

$method = $_SERVER['REQUEST_METHOD'];

if ($method === 'DELETE') {
    $data = json_decode(file_get_contents("php://input"), true);

    if (!isset($data['id_user'])) {
        $response['message'] = 'User ID is required.';
        echo json_encode($response);
        exit;
    }

    try {
        $sql = "DELETE FROM [SeeJTI].[dbo].[users] WHERE id_user = :id_user";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':id_user' => $data['id_user'],
        ]);

        if ($stmt->rowCount() > 0) {
            $response['status'] = 'success';
            $response['message'] = 'Mahasiswa Berhasil Dihapus.';
        } else {
            $response['message'] = 'Mahasiswa Tidak Ditemukan.';
        }
    } catch (PDOException $e) {
        $response['message'] = 'Error: ' . $e->getMessage();
    }

    echo json_encode($response);
    exit;
}

http_response_code(405);
$response['message'] = 'Method not allowed.';
echo json_encode($response);
