<?php
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
include 'core.php';
require './config/database.php';

header('Content-Type: application/json');
$pdo = connectDatabase();

// Query data ruang kosong
$sql = "SELECT * FROM getRuangKosong WHERE nama_hari = :nama_hari ORDER BY kode_ruang ASC, nama_hari DESC";

// Retrieve `nama_hari` from the request parameters
$namaHari = isset($_GET['nama_hari']) ? $_GET['nama_hari'] : 'Senin'; // Default to 'Senin' if not provided

$stmt = $pdo->prepare($sql);
$stmt->bindParam(':nama_hari', $namaHari, PDO::PARAM_STR);

$stmt->execute();

// Fetch all results
$available_rooms = [];
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $available_rooms[] = [
        'room_name' => $row['kode_ruang'],
        'time' => date('H:i', strtotime($row['jam_kosong_mulai'])) . '-' . date('H:i', strtotime($row['jam_kosong_selesai']))
    ];
}

$response = [
    'day' => $namaHari, // Use the request parameter for the day
    'count' => count($available_rooms),
    'available_rooms' => $available_rooms
];

echo json_encode($response, JSON_PRETTY_PRINT);
?>