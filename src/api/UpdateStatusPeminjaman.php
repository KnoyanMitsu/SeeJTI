<?php
require_once 'core.php';
require_once './config/database.php';
session_start();

try {
    $pdo = connectDatabase();
    
    if (!$pdo) {
        throw new Exception("Koneksi database gagal");
    }

    // Get POST data
    $data = json_decode(file_get_contents("php://input"), true);
    
    // Debug log
    error_log('Received data: ' . print_r($data, true));
    
    if (!isset($data['id_peminjaman']) || !isset($data['status'])) {
        throw new Exception("Data tidak lengkap. Received: " . json_encode($data));
    }

    $query = "UPDATE peminjaman SET status = :status WHERE id_peminjaman = :id_peminjaman";
    
    $stmt = $pdo->prepare($query);
    $result = $stmt->execute([
        ':status' => $data['status'],
        ':id_peminjaman' => $data['id_peminjaman']
    ]);

    if ($result) {
        echo json_encode([
            'status' => 'success',
            'message' => 'Status berhasil diperbarui'
        ]);
    } else {
        echo json_encode([
            'status' => 'error',
            'message' => 'Gagal memperbarui status'
        ]);
    }

} catch (Exception $e) {
    error_log('Error in UpdateStatusPeminjaman: ' . $e->getMessage());
    echo json_encode([
        'status' => 'error',
        'message' => $e->getMessage()
    ]);
}
?> 