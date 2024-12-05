<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
require './config/database.php';

header('Content-Type: application/json');
$pdo = connectDatabase();

// Query data ruang kosong
$sql = "SELECT kode_ruang, nama_ruang, nama_hari 
        FROM dbo.ruang 
        WHERE kode_ruang NOT IN (
            SELECT DISTINCT kode_ruang 
            FROM dbo.jadwal
            WHERE nama_hari = :nama_hari
        )
        ORDER BY kode_ruang ASC, nama_hari DESC";
        
$stmt = $pdo->prepare($sql);

// Jika Anda ingin memfilter berdasarkan hari tertentu, tambahkan parameter `nama_hari`
$namaHari = 'Senin'; // Ubah sesuai kebutuhan atau gunakan parameter dari request.
$stmt->bindParam(':nama_hari', $namaHari, PDO::PARAM_STR);

$stmt->execute();
$ruangKosong = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Format data ruang kosong
$rooms = [];
foreach ($ruangKosong as $row) {
    $roomCode = $row['kode_ruang'];
    $day = $row['nama_hari'];

    if (!isset($rooms[$roomCode])) {
        $rooms[$roomCode] = [];
    }

    $rooms[$roomCode][] = [
        'room_name' => $row['nama_ruang'],
        'day' => $day
    ];
}

// Format output JSON
$output = ['available_rooms' => []];
foreach ($rooms as $roomCode => $roomDetails) {
    $output['available_rooms'][] = [
        'code' => $roomCode,
        'details' => $roomDetails
    ];
}

echo json_encode($output, JSON_PRETTY_PRINT);
?>
