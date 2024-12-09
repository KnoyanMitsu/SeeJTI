<?php
ini_set('mssql.timeout', 6);
function checkServer($host, $timeout = 5) {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $host);
    curl_setopt($ch, CURLOPT_NOBODY, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    
    return ($response && $httpCode === 200);
}

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
