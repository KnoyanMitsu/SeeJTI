<?php
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");

include 'core.php';
require './config/database.php';

session_start();

if (!isset($_SESSION['id_user']) && $_SESSION['level'] == 'admin') {
    http_response_code(401); // Unauthorized
    echo json_encode(["error" => "User not authenticated"]);
    exit;
}

// Query data user
$pdo = connectDatabase();
$sql = "SELECT kode_mk, nama_mk 
        FROM dbo.mata_kuliah
        ORDER BY nama_mk ASC";
$stmt = $pdo->prepare($sql);
$stmt->execute();

$users = $stmt->fetchAll(PDO::FETCH_ASSOC);

if ($users) {
    $output = ['mata_kuliah' => []];
    foreach ($users as $row) {
        $output['mata_kuliah'][] = [
            'id' => $row['kode_mk'],
            'name' => $row['nama_mk'],
        ];
    }
    echo json_encode($output, JSON_PRETTY_PRINT);
} else {
    echo json_encode(["error" => "No data found"], JSON_PRETTY_PRINT);
}
?>