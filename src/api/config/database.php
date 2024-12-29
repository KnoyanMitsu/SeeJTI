<?php
ini_set('mssql.timeout', 6);

function connectDatabase() {
    $host = 'localhost';
    $dbname = 'SeeJTI';
    $username = 'sa';
    $password = 'HsnB@#PkS3Cu9fEr1bTL';
    // $host = 'LAPTOP-25E0DE8S';
    // $dbname = 'SeeJTI';
    // $username = 'sa';
    // $password = 'Vionastia06';

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
