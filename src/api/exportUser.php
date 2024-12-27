<?php
include 'config/database.php';
include 'core.php';


session_start();

if (isset($_SESSION['id_user']) && $_SESSION['level'] == 'Admin') {
$output = fopen('php://output', 'w');

fputcsv($output, ['username', 'password', 'nama', 'nim', 'kelas', 'level']);

$pdo = connectDatabase();
$query = $pdo->query("SELECT username,[password], nama, nim, kelas, [level] FROM users WHERE level != 'admin'");

if($query){
    while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
        fputcsv($output, $row);
    }
}else{
    echo "Gagal mengambil data dari database.";
}

fclose($output);
exit;
}else{
    http_response_code(401); // Unauthorized
    echo json_encode(["error" => "User not authenticated"]);
    exit;
}

?>