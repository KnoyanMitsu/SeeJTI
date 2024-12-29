<?php
require_once 'core.php';
require_once './config/database.php';
session_start();

try {
    $pdo = connectDatabase();
    
    if (!$pdo) {
        throw new Exception("Koneksi database gagal");
    }

    // Query untuk menghitung total peminjaman
    $query = "SELECT COUNT(*) as total FROM peminjaman";
    
    $stmt = $pdo->prepare($query);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($result) {
        echo json_encode([
            'status' => 'success',
            'total' => $result['total']
        ]);
    } else {
        echo json_encode([
            'status' => 'error',
            'message' => 'Gagal mengambil jumlah peminjaman'
        ]);
    }

} catch (Exception $e) {
    echo json_encode([
        'status' => 'error',
        'message' => $e->getMessage()
    ]);
}
?> 