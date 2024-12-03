<?php
require './config/database.php';

header('Content-Type: application/json');
$pdo = connectDatabase();
// Query data
$sql = "SELECT * FROM dbo.users";
$stmt = $pdo->prepare($sql);
$stmt->execute();


$jadwal = $stmt->fetchAll(PDO::FETCH_ASSOC);



$users = [];
foreach ($jadwal as $row) {
    $nama = $row['nama'];
    $role = $row['level'];
    
    $users[] = [
        'nama' => $nama,
        'level' => $role
    ];
}


// Format output JSON
$output = ['users' => $users];

echo json_encode($output, JSON_PRETTY_PRINT);
?>
