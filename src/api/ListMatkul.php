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
$sql = "SELECT nama_mk,kelas.kode_kelas
        FROM dbo.mata_kuliah, dbo.jadwal, dbo.kelas where jadwal.kode_kelas = kelas.kode_kelas AND jadwal.kode_mk = mata_kuliah.kode_mk 
        ORDER BY nama_mk ASC";
$stmt = $pdo->prepare($sql);
$stmt->execute();

$users = $stmt->fetchAll(PDO::FETCH_ASSOC);

$list = [];
if ($users) {
    foreach ($users as $row) {
        $className = $row['kode_kelas'];
        $list[$className][] = [
            'name' => $row['nama_mk'],
        ];
    }

    $output = ['classes' => []];
    foreach($list as $className => $value){
        $output['classes'][] = [
            'kelas' => $className,
            'mata_kuliah' => $value
        ];
    }
    echo json_encode($output, JSON_PRETTY_PRINT);
} else {
    echo json_encode(["error" => "No data found"], JSON_PRETTY_PRINT);
}
?>