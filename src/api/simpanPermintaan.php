<?php
include 'core.php';  
require 'config/database.php';  

session_start();
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $namaMatkul = $_POST['matkul'];  
    $kelas = $_POST['class'];  
    $hari = $_POST['day'];  
    $room = $_POST['room'];  
    $time = $_POST['time'];  
    $user = $_SESSION['id_user'];
    $pdo = connectDatabase();
    // $queryMatkul = "SELECT kode_mk FROM matkul WHERE nama_mk = ?";
    // $stmtMatkul = $pdo->prepare($queryMatkul);
    // $stmtMatkul->execute([$namaMatkul]);  
    // $matkul = $stmtMatkul->fetch(PDO::FETCH_ASSOC);

    // if ($matkul) {
    //     $idMatkul = $matkul['id_matkul'];
    // } else {
    //     die("Mata kuliah tidak ditemukan.");
    // }


    // $queryKelas = "SELECT kode_kelas FROM kelas WHERE nama_kelas = ?";
    // $stmtKelas = $pdo->prepare($queryKelas);
    // $stmtKelas->execute([$kelas]);  
    // $kelasData = $stmtKelas->fetch(PDO::FETCH_ASSOC);

    // if ($kelasData) {
    //     $kodeKelas = $kelasData['kode_kelas'];
    // } else {
    //     die("Kelas tidak ditemukan.");
    // }


    $pdo = connectDatabase();
    
    // $queryRuang = "SELECT kode_ruang FROM ruang WHERE nama_ruang = ?";
    // $stmtRuang = $pdo->prepare($queryRuang);
    // $stmtRuang->execute([$room]);  
    // $ruangData = $stmtRuang->fetch(PDO::FETCH_ASSOC);

    // if ($ruangData) {
    //     $kodeRuang = $ruangData['kode_ruang'];
    // } else {
    //     die("Ruang tidak ditemukan.");
    // }

    
    $queryInsert = "INSERT INTO dbo.peminjaman (nama_mk, kode_kelas, nama_hari, jam, kode_ruang, status, id_user) 
                    VALUES (?, ?, ?, ?, ?, 'pending', ?)";
    $stmtInsert = $pdo->prepare($queryInsert);

    try {
        $stmtInsert->execute([$namaMatkul, $kelas, $hari, $time, $room,$user]);
        echo "Permintaan peminjaman berhasil dikirim.";
    } catch (PDOException $e) {
        echo "Gagal mengirim permintaan peminjaman: " . $e->getMessage();
    }
}
?>
