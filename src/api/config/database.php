<?php
error_reporting(E_ALL); 
ini_set('display_errors', 1);   
function connectDatabase() {
    $host = 'localhost';
    $dbname = 'SeeJTI';
    $username = 'sa';
    $password = 'seejti';

    try {
        $pdo = new PDO("sqlsrv:Server=$host;Database=$dbname", $username, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $pdo;
    } catch (PDOException $e) {
        echo "Koneksi ke database gagal: " . $e->getMessage();
        return null;
    }
}
?>
