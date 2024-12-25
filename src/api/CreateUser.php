<?php
header("Access-Control-Allow-Methods: POST");
header("Content-Type: application/json");
include 'core.php';
require './config/database.php';

$response = [
    'status' => 'error',
    'message' => 'Invalid request',
];

function isAdmin($userLevel) {
    return $userLevel === 'Admin';
}

$method = $_SERVER['REQUEST_METHOD'];
if ($method === 'POST') {
    $data = json_decode(file_get_contents("php://input"), true);
    
    // Validate input
    if (!isset($data['username'], $data['password'], $data['nama'], $data['nim'], $data['kelas'], $data['level'])) {
        http_response_code(400);
        die(json_encode([
            "status" => "error",
            "message" => "Invalid input user."
        ]));
    }
    
    try {
        $conn = connectDatabase(); // Assuming this returns PDO connection
        
        // Prepare the stored procedure call using PDO
        $sql = "EXEC CreateUser :username, :password, :nama, :nim, :kelas, :level";
        $stmt = $conn->prepare($sql);
        
        // Bind parameters
        $stmt->bindValue(':username', $data['username'], PDO::PARAM_STR);
        $stmt->bindValue(':password', $data['password'], PDO::PARAM_STR); // Note: Consider using better hashing
        $stmt->bindValue(':nama', $data['nama'], PDO::PARAM_STR);
        $stmt->bindValue(':nim', $data['nim'], PDO::PARAM_STR);
        $stmt->bindValue(':kelas', $data['kelas'], PDO::PARAM_STR);
        $stmt->bindValue(':level', $data['level'], PDO::PARAM_STR);
        
        // Execute the statement
        if ($stmt->execute()) {
            $response['status'] = 'success';
            $response['message'] = 'User berhasil ditambahkan.';
            http_response_code(201); // Created
        } else {
            throw new Exception("Failed to create user");
        }
    } catch (PDOException $e) {
        http_response_code(500);
        $response['message'] = 'Database error: ' . $e->getMessage();
    } catch (Exception $e) {
        http_response_code(500);
        $response['message'] = 'Error: ' . $e->getMessage();
    }
    
    echo json_encode($response);
    exit;
}

http_response_code(405); // Method Not Allowed
$response['message'] = 'Method not allowed.';
echo json_encode($response);