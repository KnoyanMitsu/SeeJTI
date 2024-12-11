<?php
header("Access-Control-Allow-Methods: DELETE");
header("Content-Type: application/json");

include 'core.php';
require './config/database.php';

$pdo = connectDatabase();

$json = file_get_contents('php://input');
$data = json_decode($json, true);

// Validasi input
if (!isset($data['id_user'])) {
    die(json_encode([
        "status" => "error",
        "message" => "Invalid input. 'id_user' diperlukan."
    ]));
}

try {
    $params = [
        [$data['id_user'], SQLSRV_PARAM_IN]
    ];
    $sql = "{CALL DeleteUser (?)}";
    $stmt = sqlsrv_query($conn, $sql, $params);

    if ($stmt === false) {
        throw new Exception("User  gagal untuk dihapus.");
    }

    sqlsrv_free_stmt($stmt);
    sqlsrv_close($conn);

    echo json_encode([
        "status" => "success",
        "message" => "User  berhasil untuk dihapus."
    ]);
} catch (Exception $e) {
    echo json_encode([
        "status" => "error",
        "message" => $e->getMessage()
    ]);
}
?>