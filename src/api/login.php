<?php
include 'config/database.php';

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
            if ($password === $user['password']) {
                echo "success";
            } else {
                echo "error";
            }
        } else {
            echo "error";
        }
    } catch (PDOException $e) {
        echo "error";
    } finally {
        if (isset($pdo)) {
            $pdo = null;
        }
    }
} else {
    echo "error";
}
?>