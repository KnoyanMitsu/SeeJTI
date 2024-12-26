<?php

include 'core.php';
require './config/database.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $status = $_POST['status'];
    $ruang = $_POST['ruang'];
    $kelas = $_POST['kelas'];

    $pdo = connectDatabase();
    $query = "UPDATE dbo.jadwal SET status = ? where kode_ruang = ? and kode_kelas = ?";
    $stmt = $pdo->prepare($query);
    try{
        $stmt->execute([$status, $ruang , $kelas]);
        echo "Berhasil";
    } catch (PDOException $e) {
        echo "Gagal: " . $e->getMessage();
    }
}
?>