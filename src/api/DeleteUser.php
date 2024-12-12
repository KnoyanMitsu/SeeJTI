<?php
header("Access-Control-Allow-Methods: DELETE");
header("Content-Type: application/json");

include 'core.php';
require './config/database.php';

try {
    $pdo = connectDatabase();
    
    // Get and decode JSON input
    $data = json_decode(file_get_contents("php://input"), true);
    
    // Validate input
    if (!isset($data['id_user'])) {
        http_response_code(400);
        die(json_encode([
            "status" => "error",
            "message" => "Invalid input. 'id_user' diperlukan."
        ]));
    }
    
    // Prepare and execute the stored procedure
    $sql = "EXEC DeleteUser :id_user";
    $stmt = $pdo->prepare($sql);
    
    // Bind parameter and ensure it's treated as an integer if needed
    $stmt->bindValue(':id_user', $data['id_user'], PDO::PARAM_INT);
    
    if ($stmt->execute()) {
            http_response_code(200);
            echo json_encode([
                "status" => "success",
                "message" => "User berhasil untuk dihapus."
            ]);
    } else {
        throw new Exception("User gagal untuk dihapus.");
    }
    
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode([
        "status" => "error",
        "message" => "Database error: " . $e->getMessage()
    ]);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        "status" => "error",
        "message" => $e->getMessage()
    ]);
}

// No need to explicitly close PDO connection - it's handled automatically
?>