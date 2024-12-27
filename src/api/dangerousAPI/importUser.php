<?php
include '../core.php';
require '../config/database.php';
session_start();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_FILES['csvFile']) && $_FILES['csvFile']['error'] === UPLOAD_ERR_OK) {
        if (isset($_SESSION['id_user']) && $_SESSION['level'] == 'Admin') {
        $fileTmpPath = $_FILES['csvFile']['tmp_name'];
        $pdo = connectDatabase();

        try {
            $sql = "DELETE FROM [dbo].[users] WHERE [level] != 'admin'";
            $stmt = $pdo->query($sql);
            // Membuka file CSV
            $file = fopen($fileTmpPath, 'r');

            // Lewati header file CSV
            fgetcsv($file);

            // Membaca dan memasukkan setiap baris ke database
            while (($row = fgetcsv($file, 1000, ',')) !== false) {
                $username = $row[0];
                $password= $row[1];
                $nama = $row[2];
                $nim = $row[3];
                $kelas = $row[4];
                $level = $row[5];

                // Query insert ke database
                $stmt = $pdo->prepare("INSERT INTO users (username,[password],nama,nim,kelas,[level] ) VALUES (?, ?, ?, ?, ?, ?)");
                $stmt->execute([$username, $password, $nama, $nim, $kelas, $level]);
            }

            fclose($file);
            echo json_encode(['success' => true, 'message' => 'Data berhasil diimport.']);
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode(['success' => false, 'message' => 'Terjadi kesalahan: ' . $e->getMessage()]);
        }
        } else {
            http_response_code(401); // Unauthorized
            echo json_encode(["error" => "User not authenticated"]);
        }
    } else {
        http_response_code(400);
        echo json_encode(['success' => false, 'message' => 'File CSV tidak ditemukan atau terjadi kesalahan upload.']);
    }
} else {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Hanya metode POST yang diizinkan.']);
}
?>
