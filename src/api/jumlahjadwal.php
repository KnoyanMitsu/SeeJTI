<?php

include 'core.php';
require './config/database.php';

try {
    $pdo = connectDatabase();
    $query = "SELECT COUNT(*) AS total FROM getjadwal";
    $stmt = $pdo->prepare($query); 
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    echo json_encode(['total' => $result['total']]);
} catch (PDOException $e) {
    echo json_encode(['error' => 'Database error: ' . $e->getMessage()]);
}
?>
