<?php
include 'core.php';
require './config/database.php';

session_start();

if (isset($_SESSION['id_user']) && $_SESSION['level'] == 'Admin') {
$output = fopen('php://output', 'w');

fputcsv($output, ['nama_hari', 'nama_mk', 'kode_kelas', 'kode_ruang', 'nama_dosen','jam_mulai', 'jam_selesai','status']);

$pdo = connectDatabase();
$query = $pdo->query("SELECT * FROM getJadwal ORDER BY kode_kelas ASC, nama_hari DESC");

if($query){
    while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
        fputcsv($output, $row);
    }
}else{
    echo "Gagal mengambil data dari database.";
}

fclose($output);
exit;
}else{
    http_response_code(401); // Unauthorized
    echo json_encode(["error" => "User not authenticated"]);
    exit;
}
?>