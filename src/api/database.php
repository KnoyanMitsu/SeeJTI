<?php
<<<<<<< HEAD
<<<<<<< HEAD
error_reporting(E_ALL); 
ini_set('display_errors', 1);   
=======
>>>>>>> 2ae0320 (Login dan ruang kosong)
function connectDatabase() {
    $host = 'localhost';
    $dbname = 'seejti';
    $username = 'sa';
    $password = 'seejti';

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
<<<<<<< HEAD
?>
<?php
=======
>>>>>>> 52fda40 (login baru bisa, belum clean code)
function connectDatabase() {
    $host = 'localhost';
    $dbname = 'seejti';
    $username = 'sa';
    $password = 'seejti';

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
<<<<<<< HEAD
=======
>>>>>>> 2ae0320 (Login dan ruang kosong)
=======
>>>>>>> 52fda40 (login baru bisa, belum clean code)
?>