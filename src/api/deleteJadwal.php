<?php
include 'core.php';
require './config/database.php';

$pdo = connectDatabase();

$json = file_get_contents('php://input'); // isi pake directory nya
$data = json_decode($json, true);

if (!isset($data['id_jadwal'])) {
    die(json_encode(array("status" => "error", "message" => "Invalid input data. 'id_jadwal' is required.")));
}

$params = array(
    array($data['id_jadwal'], SQLSRV_PARAM_IN)
);

$sql = "{CALL DeleteJadwal(?)}";
$stmt = sqlsrv_query($conn, $sql, $params);

if ($stmt === false) {
    die(json_encode(array("status" => "error", "message" => "Jadwal gagal untuk dihapus.")));
}

sqlsrv_free_stmt($stmt);
sqlsrv_close($conn);

echo json_encode(array("status" => "success", "message" => "Jadwal berhasil untuk dihapus."));
?>
