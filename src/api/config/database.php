<?php
ini_set('mssql.timeout', 6);

function connectDatabase() {
    $host = '192.168.191.191';
    $dbname = 'SeeJTI';
    $username = 'sa';
    $password = 'HsnB@#PkS3Cu9fEr1bTL';

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
