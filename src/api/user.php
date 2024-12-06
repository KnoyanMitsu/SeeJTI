<?php
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");

include 'core.php';
require './config/database.php';

session_start();

if (!isset($_SESSION['id_user'])) {
    http_response_code(401); // Unauthorized
    echo json_encode(["error" => "User not authenticated"]);
    exit;
}

// Ambil user ID dari session
$user = $_SESSION['id_user'];

// Query data user
$pdo = connectDatabase();
$sql = "SELECT nama, nim, kelas 
        FROM dbo.users
        WHERE id_user = :user
        ORDER BY nama ASC";
$stmt = $pdo->prepare($sql);
$stmt->bindParam(':user', $user, PDO::PARAM_STR);
$stmt->execute();

$users = $stmt->fetchAll(PDO::FETCH_ASSOC);

if ($users) {
    $output = ['users' => []];
    foreach ($users as $row) {
        $output['users'][] = [
            'name' => $row['nama'],
            'nim' => $row['nim'],
            'class' => $row['kelas'],
        ];
    }
    echo json_encode($output, JSON_PRETTY_PRINT);
} else {
    echo json_encode(["error" => "No data found"], JSON_PRETTY_PRINT);
}
?>