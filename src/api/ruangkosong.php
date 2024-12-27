<?php
include 'core.php';  
require './config/database.php';  

session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $namaMatkul = $_POST['matkul'];  
    $kelas = $_POST['class'];  
    $hari = $_POST['day'];  
    $room = $_POST['room'];  
    $time = $_POST['time'];  
    $pdo = connectDatabase();

    if (!isset($_SESSION['user_id'])) {
        die("User tidak terautentikasi.");
    }
    $userId = $_SESSION['user_id'];

    $queryMatkul = "SELECT kode_mk FROM mata_kuliah WHERE kode_mk = ?";
    $stmtMatkul = $pdo->prepare($queryMatkul);
    $stmtMatkul->execute([$namaMatkul]);  
    $matkul = $stmtMatkul->fetch(PDO::FETCH_ASSOC);

    if ($matkul) {
        $idMatkul = $matkul['kode_mk'];
    } else {
        die("Mata kuliah tidak ditemukan.");
    }

    $queryKelas = "SELECT kode_kelas FROM kelas WHERE kode_kelas = ?";
    $stmtKelas = $pdo->prepare($queryKelas);
    $stmtKelas->execute([$kelas]);  
    $kelasData = $stmtKelas->fetch(PDO::FETCH_ASSOC);

    if ($kelasData) {
        $kodeKelas = $kelasData['kode_kelas'];
    } else {
        die("Kelas tidak ditemukan.");
    }

    $queryRuang = "SELECT kode_ruang FROM ruang WHERE kode_ruang = ?";
    $stmtRuang = $pdo->prepare($queryRuang);
    $stmtRuang->execute([$room]);  
    $ruangData = $stmtRuang->fetch(PDO::FETCH_ASSOC);

    if ($ruangData) {
        $kodeRuang = $ruangData['kode_ruang'];
    } else {
        die("Ruang tidak ditemukan.");
    }

    $queryInsert = "INSERT INTO dbo.peminjaman (kode_mk, kode_kelas, nama_hari, id_dosen, id_jam_mulai, id_jam_selesai, kode_ruang, status, user_id) 
                    VALUES (?, ?, ?, '12', '1', '2', ?, 'belum acc', ?)";
    $stmtInsert = $pdo->prepare($queryInsert);

    try {
        $stmtInsert->execute([$idMatkul, $kodeKelas, $hari, $kodeRuang, $userId]);
        echo "Permintaan peminjaman berhasil dikirim.";
    } catch (PDOException $e) {
        echo "Gagal mengirim permintaan peminjaman: " . $e->getMessage();
    }
}
?>