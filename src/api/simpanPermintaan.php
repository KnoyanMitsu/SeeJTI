<?php
include 'core.php';  
require './config/database.php';  


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $namaMatkul = $_POST['matkul'];  
    $kelas = $_POST['class'];  
    $hari = $_POST['day'];  
    $room = $_POST['room'];  
    $time = $_POST['time'];  

    
    $queryJam = "SELECT id_jam_mulai, id_jam_selesai FROM jam WHERE waktu = ?";
    $stmt = $pdo->prepare($queryJam);
    $stmt->execute([$time]);  
    $jam = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($jam) {
        $idJamMulai = $jam['id_jam_mulai'];
        $idJamSelesai = $jam['id_jam_selesai'];
    } else {
        die("Jam tidak ditemukan.");
    }


    $queryMatkul = "SELECT id_matkul FROM matkul WHERE kode_mk = ?";
    $stmtMatkul = $pdo->prepare($queryMatkul);
    $stmtMatkul->execute([$namaMatkul]);  
    $matkul = $stmtMatkul->fetch(PDO::FETCH_ASSOC);

    if ($matkul) {
        $idMatkul = $matkul['id_matkul'];
    } else {
        die("Mata kuliah tidak ditemukan.");
    }


    $queryKelas = "SELECT kode_kelas FROM kelas WHERE nama_kelas = ?";
    $stmtKelas = $pdo->prepare($queryKelas);
    $stmtKelas->execute([$kelas]);  
    $kelasData = $stmtKelas->fetch(PDO::FETCH_ASSOC);

    if ($kelasData) {
        $kodeKelas = $kelasData['kode_kelas'];
    } else {
        die("Kelas tidak ditemukan.");
    }

    
    $queryRuang = "SELECT kode_ruang FROM ruang WHERE nama_ruang = ?";
    $stmtRuang = $pdo->prepare($queryRuang);
    $stmtRuang->execute([$room]);  
    $ruangData = $stmtRuang->fetch(PDO::FETCH_ASSOC);

    if ($ruangData) {
        $kodeRuang = $ruangData['kode_ruang'];
    } else {
        die("Ruang tidak ditemukan.");
    }

    
    $queryInsert = "INSERT INTO dbo.peminjaman (kode_matkul, nama_kelas, nama_hari, jam_mulai, jam_selesai, kode_ruang, status) 
                    VALUES (?, ?, ?, ?, ?, ?, 'belum acc')";
    $stmtInsert = $pdo->prepare($queryInsert);

    try {
        $stmtInsert->execute([$namaMatkul, $kodeKelas, $hari, $idJamMulai, $idJamSelesai, $kodeRuang]);
        echo "Permintaan peminjaman berhasil dikirim.";
    } catch (PDOException $e) {
        echo "Gagal mengirim permintaan peminjaman: " . $e->getMessage();
    }
}
?>
