<?php
require_once 'core.php';
require_once './config/database.php';
session_start();

try {
    $pdo = connectDatabase();
    
    if (!$pdo) {
        throw new Exception("Koneksi database gagal");
    }

    // Query disesuaikan dengan struktur tabel yang sebenarnya
    $query = "SELECT 
        id_peminjaman,
        nama_mk as matkul,
        kode_ruang as ruangan,
        nama_hari,
        jam as waktu,
        kode_kelas as kelas,
        status
    FROM peminjaman
    ORDER BY id_peminjaman DESC";

    $stmt = $pdo->prepare($query);
    $stmt->execute();
    $peminjaman = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if ($peminjaman) {
        echo json_encode([
            'status' => 'success',
            'peminjaman' => $peminjaman
        ]);
    } else {
        echo json_encode([
            'status' => 'error',
            'message' => 'Tidak ada data peminjaman'
        ]);
    }

} catch (Exception $e) {
    echo json_encode([
        'status' => 'error',
        'message' => $e->getMessage()
    ]);
}
?>
