<?php
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");

include 'core.php';
require './config/database.php';

session_start();

if (!isset($_SESSION['id_user']) && $_SESSION['level'] == 'admin') {
    http_response_code(401); // Unauthorized
    echo json_encode(["error" => "User not authenticated"]);
    exit;
}

// Query data user
$pdo = connectDatabase();
$sql = "SELECT id_user, nama, nim, [level] 
        FROM dbo.users
        ORDER BY nama ASC";
$stmt = $pdo->prepare($sql);
$stmt->execute();

$users = $stmt->fetchAll(PDO::FETCH_ASSOC);

if ($users) {
    $output = ['users' => []];
    foreach ($users as $row) {
        $output['users'][] = [
            'id' => $row['id_user'],
            'name' => $row['nama'],
            'nim' => $row['nim'],
            'level' => $row['level'],
        ];
    }
    echo json_encode($output, JSON_PRETTY_PRINT);
} else {
    echo json_encode(["error" => "No data found"], JSON_PRETTY_PRINT);
}
?>