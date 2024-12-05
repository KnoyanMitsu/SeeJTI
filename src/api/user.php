<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
require './config/database.php';

header('Content-Type: application/json');
$pdo = connectDatabase();
session_start();
// Ambil kelas dari parameter (misalnya dari sesi login atau request)
$user = $_SESSION['id_user']; // Ganti ini dengan nilai dari sesi atau query string

// Query data user dengan filter kelas
$sql = "SELECT nama, nim, kelas 
        FROM dbo.users
        WHERE id_user = :user
        ORDER BY nama ASC";
$stmt = $pdo->prepare($sql);
$stmt->bindParam(':user', $user, PDO::PARAM_STR);
$stmt->execute();

$users = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Format data user
$output = ['users' => []];
foreach ($users as $row) {
    $output['users'][] = [
        'name' => $row['nama'],
        'nim' => $row['nim'],
        'class' => $row['kelas']
    ];
}

echo json_encode($output, JSON_PRETTY_PRINT);
?>
