<?php
include 'config/database.php';
include 'core.php';

// header ('Access-Control-Allow-Origin: *');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    try {
        $pdo = connectDatabase();

        $sql = "SELECT * FROM dbo.[users] WHERE username = :username";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':username', $username, PDO::PARAM_STR);
        $stmt->execute();

        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            if ( $password === $user['password'] || md5($password) === $user['password']) {
                session_start();
                $_SESSION['id_user'] = $user['id_user'];
                $_SESSION['level'] = $user['level'];    
                echo json_encode([
                    'status' => 'berhasil',
                    'level' => $user['level'],
                    'kelas' => $user['kelas'],
                    'password' => $user['password']
                ]);
                exit();
            } else {
                echo "Password salah.";
            }
        } else {
            echo "Username tidak ditemukan.";
        }
    } catch (PDOException $e) {
        echo "Kesalahan: " . $e->getMessage();
    }
}
?>
