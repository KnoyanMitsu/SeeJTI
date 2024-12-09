<?php
header("Access-Control-Allow-Methods: POST");
include 'core.php';
require './config/database.php';

$pdo = connectDatabase();

$response = [
    'status' => 'error',
    'message' => 'Invalid request',
];

$method = $_SERVER['REQUEST_METHOD'];

if ($method === 'POST') {
    $data = json_decode(file_get_contents("php://input"), true);

    if (!isset($data['id_jadwal']) || !isset($data['nama_hari']) || !isset($data['kode_kelas']) ||
    !isset($data['kode_mk']) || !isset($data['id_dosen']) || !isset($data['kode_ruang']) ||
    !isset($data['id_jam_mulai']) || !isset($data['id_jam_selesai']) || !isset($data['status'])) {
    die(json_encode(array("status" => "error", "message" => "Invalid input jadwal.")));
    }

    try {
        $params = array(
            array($data['id_jadwal'], SQLSRV_PARAM_IN),
            array($data['nama_hari'], SQLSRV_PARAM_IN),
            array($data['kode_kelas'], SQLSRV_PARAM_IN),
            array($data['kode_mk'], SQLSRV_PARAM_IN),
            array($data['id_dosen'], SQLSRV_PARAM_IN),
            array($data['kode_ruang'], SQLSRV_PARAM_IN),
            array($data['id_jam_mulai'], SQLSRV_PARAM_IN),
            array($data['id_jam_selesai'], SQLSRV_PARAM_IN),
            array($data['status'], SQLSRV_PARAM_IN)
        );
        
        $sql = "{CALL CreateJadwal(?, ?, ?, ?, ?, ?, ?, ?, ?)}";
        $stmt = sqlsrv_query($conn, $sql, $params);

        $response['status'] = 'Sukses';
        $response['message'] = 'Jadwal berhasil ditambahkan';
    } catch (PDOException $e) {
        $response['message'] = 'Error: ' . $e->getMessage();
    }

    echo json_encode($response);
    exit;
}
?>
