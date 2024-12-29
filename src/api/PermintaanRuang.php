<?php
require_once 'core.php';
require_once './config/database.php';
session_start();

try {
    // Query disesuaikan dengan struktur tabel yang sebenarnya
    function getPermintaanRuangAdmin() {
        $pdo = connectDatabase();
        if (!$pdo) {
            throw new Exception("Koneksi database gagal");
        }
    $query = "SELECT 
        id_peminjaman,
        nama_mk as matkul,
        kode_ruang as ruangan,
        nama_hari,
        jam as waktu,
        kode_kelas as kelas,
        peminjaman.id_user,
        status,
        users.nama
    FROM peminjaman , users
    where peminjaman.id_user = users.id_user
    ORDER BY id_peminjaman DESC";

    $stmt = $pdo->prepare($query);
    $stmt->execute();
    $peminjaman = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $peminjaman;
    }


    function getPermintaanRuangKetua() {
        $id_user = $_SESSION['id_user'];
        $pdo = connectDatabase();
        if (!$pdo) {
            throw new Exception("Koneksi database gagal");
        }
        $query = "SELECT 
        id_peminjaman,
        nama_mk as matkul,
        kode_ruang as ruangan,
        nama_hari,
        jam as waktu,
        kode_kelas as kelas,
        peminjaman.id_user,
        status,
        users.nama,
        users.id_user
    FROM peminjaman , users
    where peminjaman.id_user = users.id_user
    and users.id_user = ?
    ORDER BY id_peminjaman DESC";

    $stmt = $pdo->prepare($query);
    $stmt->execute([$id_user]);
    $peminjaman = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $peminjaman;
    }
    if (getPermintaanRuangAdmin() && $_SESSION['level'] == 'Admin') {
        echo json_encode([
            'status' => 'success',
            'peminjaman' => getPermintaanRuangAdmin()
        ]);
    }elseif(getPermintaanRuangKetua() && $_SESSION['level'] == 'Ketua'){
        echo json_encode([
            'status' => 'success',
            'peminjaman' => getPermintaanRuangKetua()
        ]);
    }else{ 
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
