<?php

include 'core.php';
require './config/database.php';

try {
    $pdo = connectDatabase();
    $query = "SELECT COUNT(*) AS total FROM [dbo].[users] WHERE level = :level";
    $stmt = $pdo->prepare($query); 
    $stmt->execute(['level' => 'Mahasiswa']);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    echo json_encode(['total' => $result['total']]);
} catch (PDOException $e) {
    echo json_encode(['error' => 'Database error: ' . $e->getMessage()]);
}
?>
