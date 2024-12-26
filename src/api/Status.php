<?php
// Memasukkan file koneksi database
include('database.php'); // pastikan path ini benar sesuai lokasi file database.php

// Handle the POST request
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Ambil status dan id_jadwal dari request POST
    $status = $_POST['status']; // 'yes' atau 'no'
    $id_jadwal = $_POST['id_jadwal'];

    // Map 'yes' ke 1 dan 'no' ke 0 untuk status di database
    $statusValue = ($status === 'yes') ? 1 : 0;

    // Query SQL untuk mengupdate status di tabel jadwal
    $query = "UPDATE jadwal SET status = ? WHERE id_jadwal = ?";

    // Menyiapkan query dan eksekusi
    $params = array($statusValue, $id_jadwal);
    $stmt = sqlsrv_query($conn, $query, $params);

    // Memeriksa apakah query berhasil
    if ($stmt) {
        echo json_encode(["success" => true, "message" => "Status berhasil diperbarui"]);
    } else {
        echo json_encode(["success" => false, "message" => "Gagal memperbarui status"]);
    }

    // Menutup statement
    sqlsrv_free_stmt($stmt);
}

// Menutup koneksi database
sqlsrv_close($conn);
?>
