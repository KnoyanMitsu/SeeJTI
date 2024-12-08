<?php
error_reporting(E_ALL); 
ini_set('display_errors', 1);   
function connectDatabase() {
    $host = '192.168.191.143';
    $dbname = 'SeeJTI';
    $username = 'sa';
    $password = 'Vionastia06';

    try {
        $pdo = new PDO("sqlsrv:TrustServerCertificate=yes;Server=$host;Database=$dbname", $username, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $pdo;
    } catch (PDOException $e) {
        echo "Koneksi ke database gagal: " . $e->getMessage();
        return null;
    }
}
?>
