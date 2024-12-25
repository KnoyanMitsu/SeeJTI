<?php
header("Access-Control-Allow-Methods: POST");
header("Content-Type: application/json");
include 'core.php';
require './config/database.php';

$response = [
    'status' => 'error',
    'message' => 'Invalid request',
];

$method = $_SERVER['REQUEST_METHOD'];
if ($method === 'POST') {
    $data = json_decode(file_get_contents("php://input"), true);
    
    if (!isset($data['nama_hari'], $data['id_jam_mulai'], $data['id_jam_selesai'], $data['kode_mk'], $data['id_dosen'], $data['kode_kelas'], $data['kode_ruang'])) {
        http_response_code(400);
        die(json_encode([
            "status" => "error",
            "message" => "Invalid input peminjaman."
        ]));
    }
    
    try {
        $conn = connectDatabase();
        
        $sql = "EXEC AddPeminjaman :nama_hari, :id_jam_mulai, :id_jam_selesai, :kode_mk, :id_dosen, :kode_kelas, :kode_ruang";
        $stmt = $conn->prepare($sql);
        
        $stmt->bindValue(':nama_hari', $data['nama_hari'], PDO::PARAM_STR);
        $stmt->bindValue(':id_jam_mulai', $data['id_jam_mulai'], PDO::PARAM_INT);
        $stmt->bindValue(':id_jam_selesai', $data['id_jam_selesai'], PDO::PARAM_INT);
        $stmt->bindValue(':kode_mk', $data['kode_mk'], PDO::PARAM_STR);
        $stmt->bindValue(':id_dosen', $data['id_dosen'], PDO::PARAM_INT);
        $stmt->bindValue(':kode_kelas', $data['kode_kelas'], PDO::PARAM_STR);
        $stmt->bindValue(':kode_ruang', $data['kode_ruang'], PDO::PARAM_STR);
        
        if ($stmt->execute()) {
            $response['status'] = 'success';
            $response['message'] = 'Peminjaman berhasil ditambahkan.';
            http_response_code(201);
        } else {
            throw new Exception("Failed to add peminjaman");
        }
    } catch (PDOException $e) {
        http_response_code(500);
        $response['message'] = 'Database error: ' . $e->getMessage();
    } catch (Exception $e) {
        http_response_code(500);
        $response['message'] = 'Error: ' . $e->getMessage();
    }
    
    echo json_encode($response);
    exit;
}

http_response_code(405);
$response['message'] = 'Method not allowed.';
echo json_encode($response);
