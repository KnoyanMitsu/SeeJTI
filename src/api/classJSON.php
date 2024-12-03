<?php
require './config/database.php';

header('Content-Type: application/json');
$pdo = connectDatabase();
// Query data
$sql = "SELECT * from getJadwal;";
$stmt = $pdo->prepare($sql);
$stmt->execute();


$jadwal = $stmt->fetchAll(PDO::FETCH_ASSOC);



$schedules = [];
foreach ($jadwal as $row) {
    $className = $row['kode_kelas'];
    $day = $row['nama_hari'];

    if (!isset($schedules[$className])) {
        $schedules[$className] = [];
    }
    if (!isset($schedules[$className][$day])) {
        $schedules[$className][$day] = [];
    }

    $startTime = substr($row['jam_mulai'], 0, 5);
    $endTime = substr($row['jam_selesai'], 0, 5);

    $schedules[$className][$day][] = [
        'subject' => $row['kode_mk'],
        'room' => $row['kode_ruang'],
        'time' => $startTime . ' - ' . $endTime,
    ];
}


// Format output JSON
$output = ['classes' => []];
foreach ($schedules as $className => $days) {
    $output['classes'][] = [
        'name' => $className,
        'schedule' => $days
    ];
}

echo json_encode($output, JSON_PRETTY_PRINT);
?>
