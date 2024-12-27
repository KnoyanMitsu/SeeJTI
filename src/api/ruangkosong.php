<?php
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
include 'core.php';
require './config/database.php';

header('Content-Type: application/json');
$pdo = connectDatabase();

// Query data ruang kosong
$sql = "SELECT * FROM getRuangKosong ORDER BY kode_ruang ASC, nama_hari DESC";
$stmt = $pdo->prepare($sql);
$stmt->execute();

$room = $stmt->fetchAll(PDO::FETCH_ASSOC);
// Fetch all results
$available_rooms = [];

foreach ($room as $row) {
    $namaHari = $row['nama_hari'];

    if (!isset($available_rooms[$namaHari])) {
        $available_rooms[$namaHari] = [];
    }
}
$output = [];

foreach ($room as $row) {
    $output[$row['nama_hari']][] = [
        'room_name' => $row['kode_ruang'],
        'time' => date('H:i', strtotime($row['jam_kosong_mulai'])) . '-' . date('H:i', strtotime($row['jam_kosong_selesai']))
    ];
}


// while ($row = $stmt->fetchAll(PDO::FETCH_ASSOC)) {
//     $namaHari = $row['nama_hari'];
//     $available_rooms[] = [
//         'room_name' => $row['kode_ruang'],
//         'time' => date('H:i', strtotime($row['jam_kosong_mulai'])) . '-' . date('H:i', strtotime($row['jam_kosong_selesai']))
//     ];
// }

// $response = [
//     'day' => $namaHari, // Use the request parameter for the day
//     'count' => count($available_rooms),
//     'available_rooms' => $available_rooms
// ];

echo json_encode($output, JSON_PRETTY_PRINT);
?>