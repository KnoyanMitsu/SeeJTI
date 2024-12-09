<?php

$json = file_get_contents(''); // ganti pake directory
$data = json_decode($json, true);

if (!isset($data['id_jadwal']) || !isset($data['nama_hari']) || !isset($data['kode_kelas']) ||
    !isset($data['kode_mk']) || !isset($data['id_dosen']) || !isset($data['kode_ruang']) ||
    !isset($data['id_jam_mulai']) || !isset($data['id_jam_selesai']) || !isset($data['status'])) {
    die(json_encode(array("status" => "error", "message" => "Invalid input data.")));
}

$params = array(
    array($data['id_jadwal'], SQLSRV_PARAM_IN),
    array($data['nama_hari'], SQLSRV_PARAM_IN),
    array($data['kode_kelas'], SQLSRV_PARAM_IN),
    array($data['kode_mk'], SQLSRV_PARAM_IN),
    array($data['id_dosen'], SQLSRV_PARAM_IN),
    array($data['kode_ruang'], SQLSRV_PARAM_IN),
    array($data['id_jam_mulai'], SQLSRV_PARAM_IN),
    array($data['id_jam_selesai'], SQLSRV_PARAM_IN),
    array($data['status'], SQLSRV_PARAM_IN)
);

$sql = "{CALL SaveJadwal(?, ?, ?, ?, ?, ?, ?, ?, ?)}";
$stmt = sqlsrv_query($conn, $sql, $params);

if ($stmt === false) {
    die(json_encode(array("status" => "error", "message" => "Jadwal gagal untuk ditambahkan")));
}

// Menutup koneksi
sqlsrv_free_stmt($stmt);
sqlsrv_close($conn);

// Mengembalikan respon sukses
echo json_encode(array("status" => "success", "message" => "Jadwal berhasil ditambahkan"));
?>
