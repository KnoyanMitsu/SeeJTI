<?php
include '../config/database.php';
include '../core.php';

session_start();
if  ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
    if (isset($_SESSION['id_user']) && $_SESSION['level'] == 'Admin') {
    $pdo = connectDatabase();
    $sql = "DELETE FROM [dbo].[users] WHERE [level] != 'admin'";
    $stmt = $pdo->query($sql);
    echo json_encode(['status' => 'success']);
    } else {
        http_response_code(401); // Unauthorized
        echo json_encode(["error" => "User not authenticated"]);
    }
}

?>