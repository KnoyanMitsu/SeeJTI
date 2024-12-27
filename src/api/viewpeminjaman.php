<?php
include 'core.php';
require './config/database.php';

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $pdo = connectDatabase();
    
    $query = "SELECT id_peminjaman, id_user, nama_hari, jam, kode_mk, id_dosen, kode_kelas, kode_ruang, status FROM dbo.peminjaman";
    
    try {
        $stmt = $pdo->prepare($query);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        header('Content-Type: application/json');
        echo json_encode($result);
    } catch (PDOException $e) {
        http_response_code(500);
        echo json_encode(["error" => $e->getMessage()]);
    }
}
?>
