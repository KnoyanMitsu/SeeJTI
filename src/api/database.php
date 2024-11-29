<?php
function connectDatabase() {
    $host = 'localhost';
    $dbname = 'seejti';
    $username = 'sa';
    $password = 'Vionastia06';

    try {
        $pdo = new PDO("sqlsrv:Server=$host;Database=$dbname", $username, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        echo "Koneksi ke database berhasil!<br>";
        return $pdo;
    } catch (PDOException $e) {
        echo "Koneksi ke database gagal: " . $e->getMessage();
        return null;
    }
}
?>